<?php //$this->debug($this->user) ;  ?>
<?php ?>
<div class="loader-wrapper">
    <div class="loaders">
        <div class="loader-logo-pulse">
            <img src="img/logo.png" alt="Well Fed Foundation" style="width: 50%;height: auto"> 
        </div>
        <div class="loader-1">
        </div>
    </div>
</div>

<div class="wrapper">
    <header id="menu" class="header header-transparent header-sticky">
        <nav class="navbar">
            <div class="container">
                <div class="menu-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".nav-collapse">
                        <span class="top-bar"></span>
                        <span class="middle-bar"></span>
                        <span class="bottom-bar"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <div class="nav-tools">
                        <ul class="nav navbar-nav" >
                            <?php if ($this->user) { ?>
                                <li class="nav-item">
                                    <form method="post">
                                        <input type="hidden" name="logout" value="1"/>
                                        <button type="submit" class="login-btn">Log out</button>
                                    </form>
                                </li>
                            <?php } else { ?>
                                <li class="nav-item">
                                    <button class="login-btn" data-toggle="modal" data-target="#login">Login</button>
                                </li>
                                <li class="nav-item">
                                    <button class="login-btn" data-toggle="modal" data-target="#register">Register</button>
                                </li>
                            <?php } ?>                            
                        </ul>
                    </div>
                    <div class="nav-logo">
                        <a class="logo" href=""><img class="logo-light" src="img/logo_transparent.png" alt="Eastern"></a>
                        <a class="logo" href=""><img class="logo-dark" src="img/logo_transp_white.png" alt="Eastern"></a>
                    </div>                    
                </div>
                <div class="collapse navbar-collapse nav-collapse">
                    <ul class="nav navbar-nav" >
                        <li class="nav-item">
                            <a href=""><i class="fa fa-home fa-2x"></i></a>
                        </li>
                        <li class="nav-item">
                            <a href="/about">About us</a>
                        </li>
                        <li class="nav-item">
                            <a href="/blog">Blog</a>
                        </li>
                        <li class="nav-item">
                            <a href="/contact">Contact</a>
                        </li>
                        <?php if ($this->user) { ?>
                            <li class="nav-item">
                                <a href="/profile">Profile</a>
                            </li>
                            <?php if (count($this->user['locations'])) { ?>
                                <li class="nav-item">
                                    <a href="/donations/add">Donate</a>
                                </li>
                            <?php } else { ?>
                                <li class="nav-item">
                                    <a href="/locations/add">Donate</a>
                                </li>
                            <?php } ?>
                            <?php if ($this->user['data']['advanced'] || $this->user['access'][0] == 1) { ?>
                                <li class="nav-item">
                                    <a href="/search">Search</a>
                                </li>
                            <?php } ?>
                        <?php } ?>
                        <?php if ($this->user && ($this->user['access'][0] == 1)) { ?>
                            <li class="nav-item">
                                <a href="/admin/dashboard"><i class="fa fa-cog fa-2x"></i></a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>