document.addEventListener("DOMContentLoaded", () => {
    // Modal functionality
    const modalContainer = document.getElementById("modal-container");
    const modalTitle = document.getElementById("modal-title");
    const productNameInput = document.getElementById("product-name");
    const productPriceInput = document.getElementById("product-price");
    const productQuantityInput = document.getElementById("product-quantity");
    const modalSubmitBtn = document.getElementById("modal-submit");
    const modalCloseBtn = document.getElementById("modal-close");

    // Product list container
    const productList = document.querySelector(".product-list");

    // Open modal to add a new product
    document.querySelector(".add-product").addEventListener("click", () => {
        modalTitle.textContent = "Add New Product";
        productNameInput.value = "";
        productPriceInput.value = "";
        productQuantityInput.value = "";
        modalSubmitBtn.dataset.action = "add";
        modalSubmitBtn.dataset.id = "";
        modalContainer.style.display = "flex";
    });

    // Submit modal form
    modalSubmitBtn.addEventListener("click", () => {
        const action = modalSubmitBtn.dataset.action;
        const name = productNameInput.value.trim();
        const price = productPriceInput.value.trim();
        const quantity = productQuantityInput.value.trim();

        if (!name || !price || !quantity) {
            alert("Please fill out all fields.");
            return;
        }

        if (action === "add") {
            addProduct(name, price, quantity);
        } else if (action === "update") {
            const productCard = document.querySelector(`[data-id="${modalSubmitBtn.dataset.id}"]`);
            if (productCard) {
                updateProduct(productCard, name, price, quantity);
            }
        }

        closeModal();
    });

    // Close modal
    modalCloseBtn.addEventListener("click", closeModal);

    function closeModal() {
        modalContainer.style.display = "none";
    }

    // Add product
    function addProduct(name, price, quantity) {
        const productId = Date.now(); // Unique ID based on timestamp
        const productCard = document.createElement("div");
        productCard.classList.add("product-card");
        productCard.dataset.id = productId;
        productCard.innerHTML = `
            <h4>${name}</h4>
            <p>Price: ₹${price}/kg</p>
            <p>Quantity: ${quantity} kg</p>
            <button class="product-button update" data-id="${productId}">Update</button>
            <button class="product-button delete" data-id="${productId}">Delete</button>
        `;
        productList.appendChild(productCard);

        // Attach event listeners to new buttons
        attachProductButtonListeners(productCard);
    }

    // Update product
    function updateProduct(productCard, name, price, quantity) {
        productCard.querySelector("h4").textContent = name;
        productCard.querySelector("p:nth-child(2)").textContent = `Price: ₹${price}/kg`;
        productCard.querySelector("p:nth-child(3)").textContent = `Quantity: ${quantity} kg`;
    }

    // Attach listeners to product card buttons
    function attachProductButtonListeners(productCard) {
        const updateButton = productCard.querySelector(".update");
        const deleteButton = productCard.querySelector(".delete");

        // Update button functionality
        updateButton.addEventListener("click", () => {
            modalTitle.textContent = "Update Product";
            const productId = updateButton.dataset.id;
            const name = productCard.querySelector("h4").textContent;
            const price = productCard.querySelector("p:nth-child(2)").textContent.replace("Price: ₹", "").replace("/kg", "").trim();
            const quantity = productCard.querySelector("p:nth-child(3)").textContent.replace("Quantity: ", "").replace("kg", "").trim();

            productNameInput.value = name;
            productPriceInput.value = price;
            productQuantityInput.value = quantity;
            modalSubmitBtn.dataset.action = "update";
            modalSubmitBtn.dataset.id = productId;

            modalContainer.style.display = "flex";
        });

        // Delete button functionality
        deleteButton.addEventListener("click", () => {
            if (confirm("Are you sure you want to delete this product?")) {
                productCard.style.opacity = "0"; // Fade out
                setTimeout(() => productList.removeChild(productCard), 300); // Remove after fade-out
            }
        });
    }

    // Attach listeners to existing product cards
    document.querySelectorAll(".product-card").forEach(attachProductButtonListeners);
});
