<header class="header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-5 col-md-5 col-6">
          <div class="header-left d-flex align-items-center">
            <div class="menu-toggle-btn mr-20">
              <button id="menu-toggle" class="main-btn primary-btn btn-hover">
                <i class="lni me-2 lni-chevron-left"></i> Menu
              </button>
            </div>
          </div>
        </div>
        <div class=" col-lg-7 col-md-7 col-6">
          <div class="header-right">
            <!-- notification start -->
            <!-- notification end -->
            <!-- message start -->
            <div class="header-message-box ml-15 d-none d-md-flex">
              <button
                class="dropdown-toggle"
                type="button"
                id="message"
                data-bs-toggle="dropdown"
                aria-expanded="false"
              >
                <i class="lni lni-envelope"></i>
                <span>3</span>
              </button>
              <ul
                class="dropdown-menu dropdown-menu-end"
                aria-labelledby="message"
              >
                <li>
                  <a href="#0">
                    <div class="image">
                      <img src="{{ asset('assets/images/lead/lead-5.png') }}" alt="" />
                    </div>
                    <div class="content">
                      <h6>Jacob Jones</h6>
                      <p>Hey!I can across your profile and ...</p>
                      <span>10 mins ago</span>
                    </div>
                  </a>
                </li>
                <li>
                  <a href="#0">
                    <div class="image">
                      <img src="{{ asset('assets/images/lead/lead-3.png') }}" alt="" />
                    </div>
                    <div class="content">
                      <h6>John Doe</h6>
                      <p>Would you mind please checking out</p>
                      <span>12 mins ago</span>
                    </div>
                  </a>
                </li>
                <li>
                  <a href="#0">
                    <div class="image">
                      <img src="{{ asset('assets/images/lead/lead-2.png') }}" alt="" />
                    </div>
                    <div class="content">
                      <h6>Anee Lee</h6>
                      <p>Hey! are you available for freelance?</p>
                      <span>1h ago</span>
                    </div>
                  </a>
                </li>
              </ul>
            </div>
            <!-- message end -->
            <!-- filter start -->
            <!-- filter end -->
            <!-- profile start -->
            <div class="profile-box ml-15">
              <button
                class="dropdown-toggle bg-transparent border-0"
                type="button"
                id="profile"
                data-bs-toggle="dropdown"
                aria-expanded="false"
              >
                <div class="profile-info">
                  <div class="info">
                    <h6>{{ Auth::user()->name }}</h6>
                    <div class="image">
                      <img
                        src="{{ asset('assets/images/profile/profile-image.png') }}"
                        alt=""
                      />
                      <span class="status"></span>
                    </div>
                  </div>
                </div>
                <i class="lni lni-chevron-down"></i>
              </button>
              <ul
                class="dropdown-menu dropdown-menu-end"
                aria-labelledby="profile"
              >
                {{-- <li>
                  <a href="#0">
                    <i class="lni lni-user"></i> View Profile
                  </a>
                </li>
                <li>
                  <a href="#0">
                    <i class="lni lni-alarm"></i> Notifications
                  </a>
                </li>
                <li>
                  <a href="#0"> <i class="lni lni-inbox"></i> Messages </a>
                </li>
                <li>
                  <a href="#0"> <i class="lni lni-cog"></i> Settings </a>
                </li> --}}
                <li>
                  <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <a onclick="event.preventDefault(); this.closest('form').submit();"><i class="lni lni-exit"></i> Sign Out</a>
                  </form>                      
                </li>
              </ul>
            </div>
            <!-- profile end -->
          </div>
        </div>
      </div>
    </div>
  </header>