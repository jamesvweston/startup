<?php

namespace App\Http\Controllers;


use App\Models\Card;
use App\Services\Stripe\StripeService;
use App\Http\Requests\Cards\CreateCardRequest;
use App\Http\Requests\Cards\DeleteCardRequest;
use App\Http\Requests\Cards\GetCardsRequest;
use App\Http\Requests\Cards\SetDefaultCardRequest;
use App\Http\Requests\Cards\UpdateCardRequest;

class CardController extends Controller
{

    /**
     * @var StripeService
     */
    private $stripe_service;


    public function __construct(StripeService $stripe_service)
    {
        $this->stripe_service           = $stripe_service;
    }

    public function index (GetCardsRequest $request)
    {
        $qb                     = Card::query();
        $qb->whereIn('account_id', $request->account_ids);

        if (!is_null($request->ids))
            $qb->whereIn('id', $request->ids);

        $cards                  = $qb->orderBy($request->order_by, $request->direction)
            ->paginate($request->per_page);

        return $cards;
    }

    public function store (CreateCardRequest $request)
    {
        $card               = $this->stripe_service->customers->createCard($request->account, $request->toArray());
        return response($card, 201);
    }

    public function update (UpdateCardRequest $request)
    {
        $card               = $this->stripe_service->customers->updateCard($request->account, $request->card, $request->toArray());

        return response($card, 201);
    }

    public function destroy (DeleteCardRequest $request)
    {
        $this->stripe_service->customers->deleteCard($request->account, $request->card);
        return response(null, 204);
    }

    public function setDefaultCard (SetDefaultCardRequest $request)
    {
        $card               = $this->stripe_service->customers->setDefaultCard($request->account, $request->card);
        return $card;
    }

}
