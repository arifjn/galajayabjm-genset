import "./bootstrap";
import "preline";

// to solve hamburger menu in mobile browsers
document.addEventListener("livewire:navigated", () => {
    window.HSStaticMethods.autoInit();
});
