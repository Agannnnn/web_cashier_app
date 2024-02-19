$(() => {
  refreshCart();
});

const save = () => {
  const customer = document.querySelector("#inputIdCustomer").value;
  const items = JSON.parse(localStorage.getItem("cart"));

  if (items.length > 0) {
    $.ajax({
      url: "api/cart/commit.php",
      method: "POST",
      data: { customer, items },
      success: (data) => {
        alert("Purchase is saved");
        localStorage.removeItem("cart");
        window.location.reload();
      },
      error: () => {
        alert("Purchase has failed");
      },
    });
    return;
  }

  alert("Cart is empty");
};

const refreshCart = () => {
  const cartItems = document.querySelector("#cart-items");

  cartItems.innerHTML = "";

  const cart = JSON.parse(localStorage.getItem("cart"));

  if (cart === null) return;

  let totalPrice = 0;

  cart.forEach((menu) => {
    totalPrice += menu.price;
    const itemElement = `
        <li class="list-group-item d-flex flex-row justify-content-between align-items-center">
            <span>${menu.name}</span>
            <div class="d-flex flex-row align-items-center gap-1">
                <button title="Decrease" class="btn badge bg-secondary" onclick="decreaseCartItem('${menu.id}')">${menu.qty}</button>
                <button title="Remove" class="btn badge bg-danger" onclick="removeCartItem('${menu.id}')">X</button>
            </div>
        </li>`;

    cartItems.innerHTML += itemElement;
  });

  document.querySelector("#price-total").innerHTML = `Total ${Intl.NumberFormat(
    "id-ID",
    { style: "currency", currency: "IDR" }
  ).format(totalPrice)}`;
};

const decreaseCartItem = (id) => {
  let cart = JSON.parse(localStorage.getItem("cart"));

  cart.forEach((menu, index) => {
    if (id === menu.id) {
      if (menu.qty - 1 == 0) {
        cart = cart.filter((item) => item.id != id);
      } else {
        cart[index] = {
          id,
          name: menu.name,
          price: menu.price,
          qty: --menu.qty,
        };
      }
    }
  });

  localStorage.setItem("cart", JSON.stringify(cart));
  refreshCart();
};

const addToCart = (btn) => {
  const id = btn.dataset.id;
  const stock = btn.dataset.stock;
  const name = btn.dataset.name;
  const price = btn.dataset.price;

  const cart = JSON.parse(localStorage.getItem("cart")) ?? [];

  //   Checking if the item is already in the cart, if not then insert the item to the cart
  if (cart.filter((menu) => menu.id === id).length <= 0) {
    localStorage.setItem(
      "cart",
      JSON.stringify([
        ...cart,
        {
          id,
          name,
          price: price * 1,
          qty: 1,
        },
      ])
    );
    refreshCart();
    return;
  }

  cart.forEach((menu, index) => {
    if (menu.id === id) {
      if (menu.qty + 1 <= stock) {
        cart[index] = {
          id,
          name,
          price: price * (menu.qty + 1),
          qty: ++menu.qty,
        };
      }
    }
  });

  localStorage.setItem("cart", JSON.stringify(cart));
  refreshCart();
};

const removeCartItem = (id) => {
  const cart = JSON.parse(localStorage.getItem("cart"));

  localStorage.setItem(
    "cart",
    JSON.stringify(cart.filter((menu) => menu.id !== id))
  );
  refreshCart();
};
