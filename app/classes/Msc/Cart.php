<?php

namespace Msc;

use Auth\Session;

class Cart
{
    protected Session $session;
    protected string $cartKey = 'cart';

    public function __construct()
    {
        $this->session = new Session();
    }

    // Add product to cart
    public function addToCart(array $product)
    {
        $cart = $this->session->get($this->cartKey) ?? [];

        $productId = $product['id'];
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += 1;
        } else {
            $cart[$productId] = [
                'id' => $productId,
                'name' => $product['name'],
                'price' => $product['price'],
                'image' => $product['image'],
                'quantity' => 1,
            ];
        }

        $this->session->set($this->cartKey, $cart);
        return true;
    }

    // Get all items in cart
    public function getCartItems(): array
    {
        return $this->session->get($this->cartKey) ?? [];
    }

    public function increaseCartItem($productId)
    {
        $cart = $this->session->get($this->cartKey) ?? [];

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity']++;
            $this->session->set($this->cartKey, $cart);
        }

        return true;
    }

    public function decreaseCartItem($productId)
    {
        $cart = $this->session->get($this->cartKey) ?? [];

        if (isset($cart[$productId]) && $cart[$productId]['quantity'] > 1) {
            $cart[$productId]['quantity']--;
            $this->session->set($this->cartKey, $cart);
        }

        return true;
    }

    // Remove an item from cart
    public function removeFromCart($productId): bool
    {
        $cart = $this->session->get($this->cartKey) ?? [];

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            $this->session->set($this->cartKey, $cart);
            return true;
        }

        return false;
    }

    // Get total number of items in cart
    public function getCartCount(): int
    {
        $cart = $this->session->get($this->cartKey) ?? [];
        $count = 0;
        foreach ($cart as $item) {
            $count += $item['quantity'];
        }
        return $count ?? 0;
    }
}
