<template>
    <div class="relative z-50">
        <div class="navbar bg-base-100">
            <div class="navbar-start">
                <div class="dropdown">
                    <label tabindex="0" class="btn btn-ghost lg:hidden">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16" /></svg>
                    </label>
                    <ul tabindex="0" class="menu menu-compact dropdown-content mt-3 p-2 shadow bg-base-100 rounded-box w-52">
                        <li><a>Home</a></li>
                        <li><a>About Us</a></li>
                        <li><a>Timeline</a></li>
                        <li><a>Partner</a></li>
                        <li><a>Contact</a></li>
                    </ul>
                </div>
                <a class="btn btn-ghost normal-case text-xl">
                    <img src="/img/himit-fest-logo.png" width="50px">
                </a>
            </div>
            <div class="navbar-center hidden lg:flex">
                <ul class="menu menu-horizontal p-0">
                    <li><a>Home</a></li>
                    <li><a>About Us</a></li>
                    <li><a>Timeline</a></li>
                    <li><a>Partner</a></li>
                    <li><a>Contact</a></li>
                </ul>
            </div>
            <div class="navbar-end">
                <a href="/login" class="btn btn-info">Get started</a>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "LayoutHeader"
}
</script>

<style scoped>

</style>
