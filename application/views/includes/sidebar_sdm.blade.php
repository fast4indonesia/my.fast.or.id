<div class="sidebar sidebar-main">
    <div class="sidebar-content">

        <div class="sidebar-user">
            <div class="category-content">
                <div class="media">
                            
                    <center>
                        <div class="media-body">              
                            <img src="{{$base_url}}resources/assets/images/logo-fast-landscape.png" width="180px" height="45px" alt=""/>
                            <br/>
                            <br/>
                            <span class="media-heading text-semibold">Forum Alumni Universitas Telkom</span>
                        </div>
                    </center>
                </div>
            </div>
        </div>


        <div class="sidebar-category sidebar-category-visible">
            <div class="category-content no-padding">
                <ul class="navigation navigation-main navigation-accordion">


                    <li class="navigation-header"><span>Main Menu</span> <i class="icon-menu" title="Main pages"></i></li>
                    <li {{ $controller_name == 'welcome' ? 'class="active"' : ''}}><a href="{{$base_url}}"><i class="icon-home4"></i> <span>Home</span></a></li>
                    <li {{ $controller_name == 'profiles' ? 'class="active"' : ''}}><a href="{{$base_url}}profiles"><i class="fa fa-user"></i> <span>Profile</span></a></li>
                    <li {{ $controller_name == 'profile' ? 'class="active"' : ''}}>
                        <a href="#"><i class="fa fa-group"></i> <span>Spesial Interest Group</span></a>
                        <!-- <a href="{{$base_url}}"><i class="fa fa-group"></i> <span>Spesial Interest Group</span></a> -->
                        <!-- <ul>
                            <li {{ $controller_name == 'pengangkatansma' ? 'active' : ''}}><a href="{{$base_url}}evaluasi/">Informatika</a></li>
                            <li {{ $controller_name == 'pengangkatansma' ? 'active' : ''}}><a href="{{$base_url}}evaluasi/">Industri Kreatif</a></li>
                            <li {{ $controller_name == 'pengangkatansma' ? 'active' : ''}}><a href="{{$base_url}}evaluasi/">Ilmu Terapan</a></li>
                            <li {{ $controller_name == 'pengangkatansma' ? 'active' : ''}}><a href="{{$base_url}}evaluasi/">Olahraga</a></li>
                            <li {{ $controller_name == 'pengangkatansma' ? 'active' : ''}}><a href="{{$base_url}}evaluasi/">Seni & Budaya</a></li>
                            <li {{ $controller_name == 'pengangkatansma' ? 'active' : ''}}><a href="{{$base_url}}evaluasi/">Ekonomi & Bisnis</a></li>
                            <li {{ $controller_name == 'pengangkatansma' ? 'active' : ''}}><a href="{{$base_url}}evaluasi/">Media & Komunikasi</a></li>
                            <li {{ $controller_name == 'pengangkatansma' ? 'active' : ''}}><a href="{{$base_url}}evaluasi/">Elektronika & Telekomunikasi</a></li>
                            <li {{ $controller_name == 'pengangkatansma' ? 'active' : ''}}><a href="{{$base_url}}evaluasi/">Rekayasa Industri</a></li>
                        </ul> -->
                    </li>
                    <li {{ $controller_name == 'kabaralumni' ? 'class="active"' : ''}}><a href="#"><i class="fa fa-newspaper-o"></i><span>Fast News</span></a></li>
                    <li {{ $controller_name == 'katalogusaha' ? 'class="active"' : ''}}><a href="#"><i class="fa fa-cart-plus"></i><span>Fast Store</span></a></li>
                    <li {{ $controller_name == 'pustakadigital' ? 'class="active"' : ''}}><a href="#"><i class="fa fa-book"></i><span>Digital Library</span></a></li>
                    <li {{ $controller_name == 'beasiswa' ? 'class="active"' : ''}}><a href="#"><i class="fa fa-graduation-cap"></i><span>Scholarship</span></a></li>
                    <li {{ $controller_name == 'jobcareer' ? 'class="active"' : ''}}><a href="#"><i class="fa fa-road"></i><span>Job Career</span></a></li>
                    
                    <li class="navigation-header"><span></span> <i class="icon-menu" title=""></i></li>
                    <li {{ $controller_name == 'fast' ? 'class="active"' : ''}}><a href="#"><i class="fa fa-heart-o"></i> <span>FAST</span></a></li>
                    <li {{ $controller_name == 'pengurus' ? 'class="active"' : ''}}><a href="#"><i class="fa fa-sitemap"></i> <span>Committee</span></a></li>
                </ul>
            </div>
        </div>
    </div>
</div>