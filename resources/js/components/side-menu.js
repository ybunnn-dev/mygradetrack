// resources/js/components/sideMenu.js

export default () => ({
    open: true,
    // showMenu is intentionally left here as a reminder it's local to the profile x-data scope
    activeItem: 'home',
    showMenu: false,

    init() {
        // Load cached sidebar open/closed state
        const cachedOpen = localStorage.getItem('sidebarOpen');
        if (cachedOpen !== null) {
            this.open = cachedOpen === 'true';
        }

        // Load cached active item state
        const cachedActive = localStorage.getItem('activeSidebarItem');
        if (cachedActive !== null) {
            this.activeItem = cachedActive;
        } else {
            // Fallback: Determine initial active item based on current URL path
            this.determineActiveItemFromUrl();
        }

        // Listen for browser navigation (back/forward) to update active item
        window.addEventListener('popstate', () => {
            this.determineActiveItemFromUrl();
        });
    },

    // Determines the active item based on the current URL
    determineActiveItemFromUrl() {
        const path = window.location.pathname;
        if (path.includes('/grades')) {
            this.activeItem = 'grades';
        } else if (path.includes('/metrics')) {
            this.activeItem = 'metrics';
        } else {
            // Default to 'home' if no other matches
            this.activeItem = 'home';
        }
        localStorage.setItem('activeSidebarItem', this.activeItem); // Cache it
    },

    popupPosition() {
        const sidebarWidth = this.open ? 15 : 5; // rem values
        return {
            top: this.open ? '-2.7rem' : '-1rem',
            left: `${sidebarWidth-2}rem`
        };
    },

    toggleSidebar() {
        this.open = !this.open;
        localStorage.setItem('sidebarOpen', this.open.toString());
    },

    // Method to set the active item
    setActive(itemIdentifier) {
        this.activeItem = itemIdentifier;
        localStorage.setItem('activeSidebarItem', this.activeItem);
    }
});