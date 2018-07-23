<?php

namespace App\Traits;


use App\Models\Card;

/**
 * @property    \Illuminate\Database\Eloquent\Collection    $cards
 * @package App\Traits
 */
trait HasCards
{

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cards ()
    {
        return $this->hasMany(Card::class);
    }

    /**
     * @param Card $card
     * @return bool
     */
    public function hasCard (Card $card)
    {
        return $this->cards->contains('id', $card->id);
    }

    /**
     * @param Card $card
     * @return Card
     */
    public function addCard (Card $card)
    {
        if (sizeof($this->cards) == 0)
            $card->is_default           = true;
        $this->cards()->save($card);

        return $card;
    }

    /**
     * @param Card $card
     * @return Card
     */
    public function setDefaultCard (Card $card)
    {
        $this->cards()->update(['is_default' => false]);
        $card->is_default = true;
        $card->save();
        return $card;
    }

}
