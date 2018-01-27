<!DOCTYPE HTML>

<html>
	<head>
		<title>Echo Base Finland</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="{{asset('/css/main.css')}}"/>
		<noscript><link rel="stylesheet" href="{{asset('/css/noscript.css')}}"/></noscript>
                <link rel="stylesheet" href="{{asset('dmo/css/bootstrap/css/bootstrap.css')}}">
	</head>
        
	<body class="is-loading">

		<!-- Wrapper -->
			<div id="wrapper" class="fade-in">

                            
                            <!-- Intro -->
                            <div id="intro">
                             <!--<h1>Echo Base<br />
                             Finland</h1>-->
                            <div class="image main"><img src="{{asset('images/echobaselogo.png')}}" alt="" /></div>
                             <p>X-Wing Miniatures game by FFG</p>
                             <ul class="actions">
                              <li><a href="#header" class="button icon solo fa-arrow-down scrolly">Continue</a></li>
                             </ul>
                            </div>
                            <!-- Header -->
                                <header id="header">
                                        <a href="{{url('tuomas')}}" class="logo">X-Wing Finland ranking</a>
                                </header>

				<!-- Nav 
					<nav id="nav">
						<ul class="links">
							<li class="active"><a href="index.html">Ranking</a></li>
							<li><a href="events.html">Events</a></li>   
							<li><a href="ranking.html">Ranking</a></li>                                                        
							<li><a href="tournaments.html">Tournaments</a></li>
							<li><a href="gallery.html">Gallery</a></li>
						</ul> 
						<ul class="icons">
							<li><a href="#" class="icon fa-twitter"><span class="label">Twitter</span></a></li>
							<li><a href="#" class="icon fa-facebook"><span class="label">Facebook</span></a></li>
							<li><a href="#" class="icon fa-instagram"><span class="label">Instagram</span></a></li>
						</ul>
					</nav> -->

				<!-- Main -->
                                    <div id="main">
                                        <!-- Post -->
                                        <section class="post">
                                                <header class="major">
                                                        <h1>X-WING RANKINGS</h1>   
                                                </header>
                                                <table class="results">
                                                    <tr><th>#</th><th>Name</th><th>Rating</th></tr>
                                                    @for($i = 0; $i < count($players); $i++)
                                                    <tr>
                                                        <td>{{$i+1}}</td><td>{{$players[$i]->name}}</td><td>{{$players[$i]->rating}}</td>
                                                    </tr>
                                                    @endfor
                                                </table>
                                                <div class="image main"><img src="images/xwing.png" alt="pew pew"/></div>
                                        </section>
                                        <!-- -->
                                    </div>
		<!-- Scripts -->
                <script src="{{asset('/js/jquery.min.js')}}"></script>
                <script src="{{asset('/js/jquery.scrollex.min.js')}}"></script>
                <script src="{{asset('/js/jquery.scrolly.min.js')}}"></script>
                <script src="{{asset('/js/skel.min.js')}}"></script>
                <script src="{{asset('/js/util.js')}}"></script>
                <script src="{{asset('/js/main.js')}}"></script>
	</body>
</html>