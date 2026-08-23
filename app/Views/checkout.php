<section class="page-section narrow-section">
    <div class="section-heading">
        <div>
            <p class="eyebrow">ARVEN CHECKOUT</p>
            <h1>Delivery Details</h1>
        </div>
    </div>

    <form method="POST" action="/checkout/submit" class="form-card">
        <label for="name">Full Name</label>
        <input id="name" type="text" name="name" required autocomplete="name">

        <label for="email">Email Address</label>
        <input id="email" type="email" name="email" required autocomplete="email">

        <label for="address">Delivery Address</label>
        <textarea id="address" name="address" rows="4" required autocomplete="street-address"></textarea>

        <button type="submit" class="btn btn-primary btn-block">
            Place Order
        </button>
    </form>
</section>
