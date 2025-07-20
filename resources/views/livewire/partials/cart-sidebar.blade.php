<aside class="w-1/3 flex flex-col bg-white/80 backdrop-blur-sm border-l border-gray-200/50 shadow-xl h-screen">
    <x-cart-header :total="count($cart)" />
    <x-cart-list :cart="$cart" />
    <x-cart-summary
        :subtotal="$subtotal"
        :tax="$tax"
        :total="$total"
        :payment-method="$paymentMethod"
    />
</aside>
