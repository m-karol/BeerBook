/**
 * @param {string} message - The message to display.
 */
function showModal(message) {
    const modal = /** @type {HTMLElement|null} */ (document.getElementById("modal"));
    const modalMessage = /** @type {HTMLElement|null} */ (document.getElementById("modal-message"));
    const modalClose = /** @type {HTMLElement|null} */ (document.getElementById("modal-close"));

    if (!modal || !modalMessage || !modalClose) return;

    modalMessage.textContent = message;
    modal.classList.remove("hidden");

    modalClose.onclick = () => {
        modal.classList.add("hidden");
    };

    modal.onclick = (e) => {
        if (e.target === modal) modal.classList.add("hidden");
    };
}

document.addEventListener("DOMContentLoaded", () => {
    const loginForm = /** @type {HTMLFormElement|null} */ (document.getElementById("loginForm"));
    if (loginForm) {
        loginForm.addEventListener("submit", async (e) => {
            e.preventDefault();
            const data = new FormData(loginForm);
            const res = await fetch("/login", { method: "POST", body: data });
            const json = await res.json();
            if (json.error) {
                showModal(json.error);
            } else if (json.success) {
                window.location.href = "/";
            }
        });
    }

    const registerForm = /** @type {HTMLFormElement|null} */ (document.getElementById("registerForm"));
    if (registerForm) {
        registerForm.addEventListener("submit", async (e) => {
            e.preventDefault();
            const data = new FormData(registerForm);
            const res = await fetch("/register", { method: "POST", body: data });
            const json = await res.json();
            if (json.error) {
                showModal(json.error);
            } else if (json.success) {
                // Show success message after registration
                showModal("Registration successful! You can now log in.");
                registerForm.reset();
            }
        });
    }

    const postLink = /** @type {HTMLElement|null} */ (document.getElementById("newPostLink"));
    const postForm = /** @type {HTMLFormElement|null} */ (document.getElementById("postForm"));

    if (postLink && postForm) {
        postLink.addEventListener("click", (e) => {
            e.preventDefault();
            postForm.classList.toggle("hidden");
            postForm.scrollIntoView({ behavior: "smooth" });
        });
    }

    if (postForm) {
        postForm.addEventListener("submit", /** @param {SubmitEvent} e */ async (e) => {
            e.preventDefault();
            const data = new FormData(postForm);
            const res = await fetch("/post", {
                method: "POST",
                body: data
            });
            const json = await res.json();
            if (json.error) showModal(json.error);
            else location.reload();
        });
    }

    const commentForm = /** @type {HTMLFormElement|null} */ (document.getElementById("commentForm"));
    if (commentForm) {
        commentForm.addEventListener("submit", /** @param {SubmitEvent} e */ async (e) => {
            e.preventDefault();
            const postId = window.location.pathname.split("/")[2]; // /post/{id}
            const data = new FormData(commentForm);
            const res = await fetch(`/post/${postId}/comment`, {
                method: "POST",
                body: data
            });
            const json = await res.json();
            if (json.error) showModal(json.error);
            else location.reload();
        });
    }

    const clickablePosts = document.querySelectorAll(".clickable-post");
    clickablePosts.forEach(post => {
        post.style.cursor = "pointer"; // show hand cursor
        post.addEventListener("click", () => {
            const postId = post.dataset.postId;
            if (postId) {
                window.location.href = `/post/${postId}`;
            }
        });
    });

    const randomPostLink = /** @type {HTMLElement|null} */ (document.getElementById("randomPostLink"));
    if (randomPostLink) {
        randomPostLink.addEventListener("click", async (e) => {
            e.preventDefault();
            try {
                const res = await fetch("/random-post");
                const json = await res.json();
                if (json.error) showModal(json.error);
                else if (json.postId) {
                    window.location.href = `/post/${json.postId}`;
                }
            } catch (err) {
                showModal("Failed to fetch a random post");
                console.error(err);
            }
        });
    }
});
