<nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">

    <button
        style="width: 120px;"
        class="btn btn-primary"
        id="menu-toggle"
        type="button"
    >
        Toggle Menu
    </button>


    <button
        class="navbar-toggler"
        type="button"
        data-toggle="collapse"
        data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent"
        aria-expanded="false"
        aria-label="Toggle navigation"
    >

        <span class="navbar-toggler-icon"></span>

    </button>


    <div
        class="collapse navbar-collapse"
        id="navbarSupportedContent"
    >

        <ul class="navbar-nav ml-auto mt-2 mt-lg-0">

            <li class="nav-item">

                <form
                    method="POST"
                    action="{{ route('admin.logout') }}"
                    class="m-0"
                >

                    @csrf

                    <button
                        type="submit"
                        class="btn btn-link nav-link"
                    >
                        Logout
                    </button>

                </form>

            </li>

        </ul>

    </div>

</nav>