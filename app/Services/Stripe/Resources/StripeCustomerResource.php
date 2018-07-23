<?php

namespace App\Services\Stripe\Resources;


use App\Models\Card;
use App\Models\Account;
use App\Models\Country;
use jamesvweston\Stripe\Requests\CreateCardRequest;
use jamesvweston\Stripe\Requests\CreateCustomerRequest;

class StripeCustomerResource extends BaseStripeResource
{

    /**
     * @param Account $account
     * @return Account
     * @throws \jamesvweston\Stripe\Exceptions\StripeException
     */
    public function export (Account $account)
    {
        $request                = new CreateCustomerRequest();
        $request->setEmail($account->owner->email);
        $request->setDescription($account->name);
        $stripe_customer        = $this->client->customers->create($request);

        $account->stripe_id     = $stripe_customer->getId();
        $account->save();
        return $account;
    }

    /**
     * @param Account $account
     * @throws \jamesvweston\Stripe\Exceptions\StripeException
     */
    public function update (Account $account)
    {
        $request                = [
            'email'             => $account->owner->email,
            'description'       => $account->name,
        ];

        $this->client->customers->update($account->stripe_id, $request);

    }


    public function createCard (Account $account, $card)
    {
        $request                = new CreateCardRequest();
        $request->setName($card['name']);
        $request->setNumber($card['number']);
        $request->setCvc($card['cvc']);
        $request->setExpMonth($card['exp_month']);
        $request->setExpYear($card['exp_year']);
        $request->setAddressZip($card['address_zip']);

        $country                = Country::find($card['country_id']);
        $request->setAddressCountry($country->code);

        $stripe_card            = $this->client->customers->createCard($account->stripe_id, $request);
        $card                   = new Card();
        $card->name             = $stripe_card->getName();
        $card->last4            = $stripe_card->getLast4();
        $card->exp_month        = $stripe_card->getExpMonth();
        $card->exp_year         = $stripe_card->getExpYear();
        $card->brand            = $stripe_card->getBrand();
        $card->funding          = $stripe_card->getFunding();
        $card->address_zip      = $stripe_card->getAddressZip();
        $card->account_id       = $account->id;
        $card->country_id       = $country->id;
        $card->stripe_id        = $stripe_card->getId();

        if (empty($account->cards))
            $card->is_default   = true;

        $account->addCard($card);

        return $card;
        //  is_default
    }

    /**
     * @param Account $account
     * @param Card $card
     * @param array $request
     * @return Card
     * @throws \jamesvweston\Stripe\Exceptions\StripeException
     */
    public function updateCard (Account $account, Card $card, $request)
    {
        $stripe_card            = $this->client->customers->updateCard($account->stripe_id, $card->stripe_id, $request);

        $card->name             = $stripe_card->getName();
        $card->last4            = $stripe_card->getLast4();
        $card->exp_month        = $stripe_card->getExpMonth();
        $card->exp_year         = $stripe_card->getExpYear();
        $card->brand            = $stripe_card->getBrand();
        $card->funding          = $stripe_card->getFunding();
        $card->address_zip      = $stripe_card->getAddressZip();
        $card->account_id       = $account->id;
        $card->stripe_id        = $stripe_card->getId();
        $card->save();

        return $card;
    }

    /**
     * @param Account $account
     * @param Card $card
     * @return Card
     * @throws \jamesvweston\Stripe\Exceptions\StripeException
     */
    public function setDefaultCard (Account $account, Card $card)
    {
        $request = [
            'default_source'    => $card->stripe_id,
        ];
        $this->client->customers->update($account->stripe_id, $request);
        $account->setDefaultCard($card);
        return $card;
    }


    /**
     * @param Account $account
     * @param Card $card
     * @throws \jamesvweston\Stripe\Exceptions\StripeException
     */
    public function deleteCard (Account $account, Card $card)
    {
        $this->client->customers->deleteCard($account->stripe_id, $card->stripe_id);
        $card->delete();

        /**
         * When a card is deleted in stripe that is the default stripe will update the most recently added card to default.
         * We need to sync our cards to reflect this
         */
        $stripe_customer            = $this->client->customers->show($account->stripe_id);

        $default_stripe_card_id     = $stripe_customer->getDefaultSource();
        if (!is_null($default_stripe_card_id))
        {
            $default_card           = $account->cards()->where('stripe_id', '=', $default_stripe_card_id)->first();
            $account->setDefaultCard($default_card);
        }
    }
}
