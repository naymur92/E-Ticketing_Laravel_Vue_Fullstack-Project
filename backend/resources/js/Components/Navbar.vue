<template>
  <nav
    class="front-navbar navbar sticky-top navbar-expand-lg navbar-light p-0"
    style="background-color: #e3f2fd"
  >
    <div class="container">
      <a class="navbar-brand" href="/">E-Ticket</a>
      <button
        class="navbar-toggler"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <router-link class="nav-link" to="/">Home</router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link" to="/login">Login</router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link" to="/register">Register</router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link" to="/verify-ticket"
              >Verify Ticket</router-link
            >
          </li>
          <li class="nav-item">
            <router-link class="nav-link" to="/train-information"
              >Train Information</router-link
            >
          </li>
          <li class="nav-item">
            <router-link class="nav-link" to="/contact-us"
              >Contact Us</router-link
            >
          </li>
          <li class="nav-item dropdown">
            <a
              class="nav-link dropdown-toggle"
              href="#"
              id="navbarDropdown"
              role="button"
              data-bs-toggle="dropdown"
              aria-expanded="false"
            >
              <span>Naymur Rahman</span>
            </a>
            <ul
              class="dropdown-menu"
              aria-labelledby="navbarDropdown"
              style="background-color: #e3f2fd"
            >
              <li>
                <span class="dropdown-item"><strong>Admin</strong></span>
              </li>
              <li>
                <span class="dropdown-item"
                  ><strong>Naymur Rahman</strong></span
                >
              </li>
              <li>
                <span class="dropdown-item">
                  <i class="fa fa-envelope"></i>
                  <span class="mx-2">naymurrahman@yahoo.com</span>
                </span>
              </li>
              <li>
                <span class="dropdown-item">
                  <i class="fa fa-phone"></i>
                  <span class="mx-2">01737036324</span>
                </span>
              </li>
              <li>
                <hr class="dropdown-divider" />
              </li>
              <li>
                <a class="dropdown-item" href="#">
                  <i class="fa-solid fa-gauge-high"></i>
                  <span class="mx-2">Dashboard</span>
                </a>
              </li>
              <li>
                <a class="dropdown-item" href="#">
                  <i class="fa fa-user"></i>
                  <span class="mx-2">Profile</span>
                </a>
              </li>
              <li>
                <a class="dropdown-item" href="#">
                  <i class="fa fa-briefcase"></i>
                  <span class="mx-2">Purchase History</span>
                </a>
              </li>
              <li>
                <a class="dropdown-item" href="#">
                  <i class="fa fa-shield-halved"></i>
                  <span class="mx-2">Update Password</span>
                </a>
              </li>
              <li>
                <a class="dropdown-item" href="#">
                  <i class="fa fa-sign-out"></i>
                  <span class="mx-2">Logout</span>
                </a>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</template>
<script>
export default {};
</script>
<style>
.front-navbar .navbar-brand {
  font-weight: 800;
  font-size: 2.5em;
  color: rgb(1, 73, 95);
  text-shadow: 2px 3px 5px rgba(0, 0, 0, 0.349);
}
.front-navbar .navbar {
  box-shadow: 0px 5px 5px #ddd;
}
.front-navbar .nav-link {
  font-weight: 600;
}
.front-navbar .dropdown-item {
  font-weight: 600;
  color: rgba(0, 0, 0, 0.55);
}
.front-navbar .dropdown-menu,
.front-navbar .nav-link {
  padding: 25px 15px !important;
}
.front-navbar .nav-link:hover {
  background-color: #ddd;
  color: black;
}
.front-navbar .dropdown-toggle span {
  font-weight: 800;
  border: 1px solid rgba(0, 0, 0, 0.55);
  padding: 10px;
  border-radius: 5px;
}
.front-navbar a.active {
  color: rgb(1, 73, 95) !important;
  font-weight: 800;
  text-shadow: 0px 0px 7px #383737;
}
</style>