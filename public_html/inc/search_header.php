<!DOCTYPE html>
<html lang="en">
<!-- Head -->

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title><? echo $pagetitle; ?></title>
    <meta name="description" content="<? echo $desc; ?>">
    <meta name="keywords" content="<? echo $keywords; ?>">  
    <link href="/assets/img/logos/favicon.png" rel="shortcut icon">
    <link href="/assets/css/plugins.css" rel="stylesheet">
    <link href="/assets/fonts/tabler-icons/tabler-icons.min.css" rel="stylesheet">
    <link href="/assets/css/theme.css" rel="stylesheet">


<style>

#preloader{display:none !important;}

.plyr { min-width: 100px; max-height:100px; }
body { background-color:#eff2f4; }

</style>

<script>
function showDiv() {
  
  document.getElementById('loadingGif').style.display = "block";
  setTimeout(function() {
    document.getElementById('loadingGif').style.display = "none";

  },9000);
   
}
</script>


<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-F8BHXZW9HN"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-F8BHXZW9HN');
</script>

<script>
    (function(w,d,t,r,u)
    {
        var f,n,i;
        w[u]=w[u]||[],f=function()
        {
            var o={ti:"97086838", enableAutoSpaTracking: true};
            o.q=w[u],w[u]=new UET(o),w[u].push("pageLoad")
        },
        n=d.createElement(t),n.src=r,n.async=1,n.onload=n.onreadystatechange=function()
        {
            var s=this.readyState;
            s&&s!=="loaded"&&s!=="complete"||(f(),n.onload=n.onreadystatechange=null)
        },
        i=d.getElementsByTagName(t)[0],i.parentNode.insertBefore(n,i)
    })
    (window,document,"script","//bat.bing.com/bat.js","uetq");
</script>


</head>
<!-- /Head -->
<!-- Set Body to full screen when Preloader is showing. -->

<body class="vh-100 vw-100 overflow-hidden">
    <!-- Header -->
    <!-- Preloader -->
    <div class="position-fixed top-0 bottom-0 bg-body vw-100 z-1100 align-items-center justify-content-center" id="preloader">
        <div class="spinner-grow text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
    <!-- /Preloader -->
   
   
   
    <!-- Header -->
    <header id="header" class="header">
        <nav class="navbar navbar-main navbar-expand-xl fw-semibold" style="background-color:#eff2f4;">
            <div class="container">
                <!-- Brand -->
                 <a class="navbar-brand" id="brandHeader" href="/" style="margin-right:0;">
                    <img src="/assets/img/<? if (isset($logo)) { echo $logo; } else { echo "travsav_logo_all.png"; } ?>" class="logo" alt="TravSavers - Save Big On Hotel, Attraction, and Vacation Packages!" style="max-width:175px; position:relative; top:-5px;">
                    
                </a>
                <!-- /Brand -->
                <!-- offcanvas Navbar -->
                <div class="offcanvas offcanvas-navbar offcanvas-end border-start-0" tabindex="-1" id="offcanvasNavbar">
                    <!-- Offcanvas header -->
                    <div class="offcanvas-header pb-0">
                        <h3 class="offcanvas-title h1" id="bdSidebarOffcanvasLabel">TravSavers</h3>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <!-- /Offcanvas header -->
                    <div class="offcanvas-body justify-content-between">
                        <!-- Navbar nav-->
                        <ul class="navbar-nav align-items-xl-center">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle-hover active  " href="/" data-bs-display="static">
                                    <span>Home</span>
                                </a>
                            </li>
                           
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle-hover " href="#" data-bs-display="static">
                                    <span>Destinations</span>
                                    <i class="ti ti-chevron-down dropdown-toggle-icon"></i>
                                </a>
                                <ul class="dropdown-menu mt-xl-8" data-bs-popper="static">
                                  
         <li><a class="dropdown-item " href="/lasvegas/">Las Vegas, NV</a></li>
 <li><a class="dropdown-item " href="/orlando/">Orlando, FL</a></li>
 <li><a class="dropdown-item " href="/gatlinburg/">Gatlinburg, TN</a></li>
 <li><a class="dropdown-item " href="/branson/">Branson, MO</a></li>
                                </ul>
                            </li>

                            
                        </ul>
                        <!-- /Navbar nav -->
                        
 <!-- /Sub Links -->
 

                    </div>
                </div>
                <!-- /offcanvas Navbar -->
                <!-- Account link -->
                <div style="margin-left:0;">

                  




                        <span class='fs-4'><i class='ti ti-phone'></i></span>
                        <span style="font-size:75%">(866) 540-8956</span>
                    

                </div>
                <!-- /Account link -->
                <!-- Nav toggler -->
                <button class="navbar-toggler ms-6" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <!-- /Nav toggler -->
            </div>

        </nav>
    </header>
    <!-- /Header -->