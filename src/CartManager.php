<?php
class CartManager {
    private $cart;

    public function __construct(&$cart) {
        $this->cart = &$cart; // Referencia al carrito (puede ser $_SESSION['cart'] o cualquier array)
    }

    public function addProductToCart($productId, $quantity) {
        if (isset($this->cart[$productId])) {
            $this->cart[$productId]['quantity'] += $quantity;
        } else {
            $this->cart[$productId] = ['quantity' => $quantity];
        }
        return $this->cart;
    }

    public function updateCart($quantities) {
        foreach ($quantities as $productId => $quantity) {
            if ($quantity == 0) {
                unset($this->cart[$productId]);
            } else {
                $this->cart[$productId]['quantity'] = $quantity;
            }
        }
        return $this->cart;
    }

    public function removeProduct($productId) {
        unset($this->cart[$productId]);
        return $this->cart;
    }

    public function clearCart() {
        $this->cart = [];
    }

    public function getCart() {
        return $this->cart;
    }
}
?>
