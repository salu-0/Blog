<!-- Footer Component -->
<footer class="w-full" style="background-color: #000000; color: #ffffff; padding-top: 3rem; padding-bottom: 3rem;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" style="max-width: 1280px; margin-left: auto; margin-right: auto; padding-left: 1rem; padding-right: 1rem;">
        <div style="display: grid; grid-template-columns: repeat(1, minmax(0, 1fr)); gap: 2rem;" class="sm:grid-cols-2 lg:grid-cols-4">
            <!-- Left Section: Logo and Copyright -->
            <div style="display: block;">
                <!-- Freshwave Logo -->
                <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1.25rem;">
                    <div style="width: 2.5rem; height: 2.5rem; background-color: #2563eb; border-radius: 9999px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <span style="color: #ffffff; font-weight: 700; font-size: 1.125rem;">F</span>
                    </div>
                    <span style="color: #ffffff; font-weight: 700; font-size: 1.5rem;">Freshwave</span>
                </div>
                <!-- Copyright -->
                <p style="font-size: 0.875rem; color: #9ca3af; font-weight: 400; margin: 0;">
                    © {{ date('Y') }} Freshwave
                </p>
            </div>

            <!-- Get the app Column -->
            <div style="display: block;">
                <h3 style="font-weight: 700; font-size: 1rem; margin-bottom: 1.25rem; color: #ffffff; margin-top: 0;">Get the app</h3>
                <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 0.75rem;">
                    <li style="display: block;">
                        <a href="#" style="color: #ffffff; font-size: 0.875rem; text-decoration: none; transition: color 0.2s;">iOS</a>
                    </li>
                    <li style="display: block;">
                        <a href="#" style="color: #ffffff; font-size: 0.875rem; text-decoration: none; transition: color 0.2s;">Android</a>
                    </li>
                </ul>
            </div>

            <!-- Quick links Column -->
            <div style="display: block;">
                <h3 style="font-weight: 700; font-size: 1rem; margin-bottom: 1.25rem; color: #ffffff; margin-top: 0;">Quick links</h3>
                <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 0.75rem;">
                    <li style="display: block;">
                        <a href="{{ route('posts.index') }}" style="color: #ffffff; font-size: 0.875rem; text-decoration: none; transition: color 0.2s;">Explore</a>
                    </li>
                    <li style="display: block;">
                        <a href="#" style="color: #ffffff; font-size: 0.875rem; text-decoration: none; transition: color 0.2s;">Shop</a>
                    </li>
                    <li style="display: block;">
                        <a href="#" style="color: #ffffff; font-size: 0.875rem; text-decoration: none; transition: color 0.2s;">Users</a>
                    </li>
                    <li style="display: block;">
                        <a href="#" style="color: #ffffff; font-size: 0.875rem; text-decoration: none; transition: color 0.2s;">Collections</a>
                    </li>
                    <li style="display: block;">
                        <a href="#" style="color: #ffffff; font-size: 0.875rem; text-decoration: none; transition: color 0.2s;">Shopping</a>
                    </li>
                    <li style="display: block;">
                        <a href="#" style="color: #ffffff; font-size: 0.875rem; text-decoration: none; transition: color 0.2s;">Help Centre</a>
                    </li>
                </ul>
            </div>

            <!-- Policies Column -->
            <div style="display: block;">
                <h3 style="font-weight: 700; font-size: 1rem; margin-bottom: 1.25rem; color: #ffffff; margin-top: 0;">Policies</h3>
                <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 0.75rem;">
                    <li style="display: block;">
                        <a href="#" style="color: #ffffff; font-size: 0.875rem; text-decoration: none; transition: color 0.2s;">Terms of Service</a>
                    </li>
                    <li style="display: block;">
                        <a href="#" style="color: #ffffff; font-size: 0.875rem; text-decoration: none; transition: color 0.2s;">Privacy Policy</a>
                    </li>
                    <li style="display: block;">
                        <a href="#" style="color: #ffffff; font-size: 0.875rem; text-decoration: none; transition: color 0.2s;">Non-user notice</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</footer>

<style>
@media (min-width: 640px) {
    footer div[style*="grid-template-columns"] {
        grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
    }
}
@media (min-width: 1024px) {
    footer div[style*="grid-template-columns"] {
        grid-template-columns: repeat(4, minmax(0, 1fr)) !important;
    }
}
footer a:hover {
    color: #d1d5db !important;
}
</style>

