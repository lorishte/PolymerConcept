<?php
	include('inc/connection.inc.php');
?>
<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Polymer Concept v.02-bg</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/simple-slider.css">
    <link rel="stylesheet" href="css/responsive.css">
    <script src="scripts/simple-slider.js"></script>
	<script type="text/javascript" src="js/fns.js"></script>
</head>
<body>


<header id="home" class="hero-container">

    <nav class="nav-primary">

        <a href="#home" class="brand"></a>

        <button class="toggle-menu">Меню</button>
        <ul class="main-nav">
			<?php
				$stmt = $mysqli->prepare("SELECT t.id,
					t.name_".$_REQUEST['lg'].",
					t.url,
					u.id,
					u.name_".$_REQUEST['lg'].",
					u.url
				FROM menus t 
					LEFT JOIN menus u ON (t.id = u.parent AND u.status = '1')
				WHERE t.parent = 0 AND
					t.type = '1' AND
					t.status = '1'
				ORDER BY t.ord, t.id, u.ord, u.id");
				$stmt->execute();
				$stmt->bind_result($b_id, $b_name, $b_url, $s_id, $s_name, $s_url);
				while ($stmt->fetch()) 
				{
					$menus[$b_id] = array('name'=>$b_name, 'url'=>$b_url);
					$mnus[$b_id][$s_id] = array('name'=>$s_name, 'url'=>$s_url);
				}
				$stmt->close();
				
				foreach ($menus as $key=>$val)
				{
					if($val['name'] == 'Продукти')
					{
						echo'<li class="nav-item" id="products-menu-link">';
					}
					else
					{
						echo '<li class="nav-item">';
					}
					
					echo'<a href="#m_'.$key.'" class="nav-link">'.$val['name'].'</a>
							<ul class="sub-menu">';
							if (!empty($mnus[$key]))
							{
								foreach($mnus[$key] as $say=>$sal)
								{
									echo'<li class="sub-menu-item"><a class="sub-menu-link" href="#m_'.$say.'">'.$sal['name'].'</a></li>';
								}
							}	
				    echo'	</ul>
						</li>';
				}
			?>
        </ul>
    </nav>

    <div id="carousel" class="carousel">

        <div id="slide-preview"></div>

        <div class="carousel-content">
			<?php
				$stmt = $mysqli->prepare("SELECT t.id,
				t.name_".$_REQUEST['lg'].",
				t.pic,
				t.url,
				t.body_".$_REQUEST['lg']."
				FROM homepics t
				WHERE t.flag = '1'
				ORDER BY RAND()");
				$stmt->execute();
				$stmt->bind_result($id, $name, $pic, $url, $pic_body);
				while ($stmt->fetch()) 
				{
					$i++;
					echo '<div class="carousel-item '.($i == 1 ? 'active': '').'">
							<div class="slide-text">
								<h1 class="headline">'.$name.'</h1>
								<p class="description">'.$pic_body.'</p>
							</div>
							<div class="slide-background">
								<img class="slider-image" src="'.str_replace('..', '', $pic).'">
							</div>
						 </div>';
				}
			?>

        </div>

        <div class="carousel-navigation">
            <a class="carousel-control-prev" href="#" role="button">
                <i class="fa fa-arrow-left" aria-hidden="true"></i>
                <span class="sr-only">Previous</span>
            </a>

            <a class="carousel-control-next" href="#" role="button" data-slide="next">
                <i class="fa fa-arrow-right" aria-hidden="true"></i>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>

</header>

<main>
	<?php
		$stmt = $mysqli->prepare("SELECT t.id,
					t.name_".$_REQUEST['lg'].",
					t.url,
                    t.lbl_".$_REQUEST['lg'].",
                    t.short_".$_REQUEST['lg'].",
                    t.body_".$_REQUEST['lg'].",
					u.id,
					u.name_".$_REQUEST['lg'].",
					u.url,
                    u.lbl_".$_REQUEST['lg'].",
                    u.short_".$_REQUEST['lg'].",
                    u.body_".$_REQUEST['lg'].",
                    i.id,
                    i.name_".$_REQUEST['lg'].",
                    i.url,
                    i.lbl_".$_REQUEST['lg'].",
                    i.short_".$_REQUEST['lg'].",
                    i.body_".$_REQUEST['lg'].",
					a.id,
                    a.name_".$_REQUEST['lg'].",
                    a.url,
                    a.lbl_".$_REQUEST['lg'].",
                    a.short_".$_REQUEST['lg'].",
                    a.body_".$_REQUEST['lg'].",
					a.pic,
					DATE_FORMAT(a.action_date, '%d') as day,
					DATE_FORMAT(a.action_date, '%M') as month,
					DATE_FORMAT(a.action_date, '%Y') as year
				FROM menus t 
					LEFT JOIN menus u ON (t.id = u.parent AND u.status = '1')
                    LEFT JOIN items i on (u.id = i.menu_id AND i.status = '1')
					LEFT JOIN items a on (t.id = a.menu_id AND a.status = '1')
				WHERE t.parent = 0 AND
					t.type = '1' AND
					t.status = '1'
				ORDER BY t.ord, t.id, u.ord, u.id");
		$stmt->execute();
		$stmt->bind_result($m_id, $m_name, $m_url, $m_lbl, $m_short, $m_body, $sm_id, $sm_name, $sm_url, $sm_lbl, $sm_short, $sm_body, $i_id, $i_name, $i_url, $i_lbl, $i_short, $i_body, $a_id, $a_name, $a_url, $a_lbl, $a_short, $a_body, $a_pic, $a_day, $a_month, $a_year);
		while ($stmt->fetch()) 
		{
			$sections[$m_id] = array('name'=>$m_name, 'body'=>$m_body);
			$categories[$m_id][$sm_id] = array('name'=>$sm_name, 'lbl'=>$sm_lbl, 'body'=>$sm_body);
			$articles[$m_id][$sm_id][$i_id] = array('name'=>$i_name, 'url'=>$i_url, 'lbl'=>$i_lbl, 'body'=>$i_body, 'pic'=>$i_pic);
			$articless[$m_id][$a_id] = array('name'=>$a_name, 'url'=>$a_url, 'lbl'=>$a_lbl, 'body'=>$a_body, 'pic'=>$a_pic, 'day'=>$a_day, 'month'=>$a_month, 'year'=>$a_year);
		}
		$stmt->close();
		
		foreach($sections as $key=>$val)
		{
				if($key==1)
				{
					echo '<section id="m_'.$key.'" class="section">';
					foreach($categories[$key] as $say=>$sal)
					{
							if($say==2)
							{
								echo '<section id="m_'.$say.'" class="inner-section about">';
								echo '<h3><span class="accent-text">12+</span> години опит</h3>
								<p class="subhead">'.$sal['lbl'].'</p>
								<p class="section-text">'.$sal['body'].'</p>';
							}
							elseif($say==3)
							{
								echo '<section id="m_'.$say.'" class="inner-section services">';
								 echo'<h3>'.$sal['name'].'</h3>
								 <div class="wrapper">';
									foreach($articles[$key][$say] as $bay=>$bal)
									{
										echo'<article class="article-box">
											<div class="article-image">
												<i class="fa fa-check" aria-hidden="true"></i>
											</div>

											<div class="article-content">
												<h4>'.$bal['name'].'</h4>
												<p>'.$bal['body'].'</p>
											</div>
										</article>';
									}
								echo'</div>';
							}
							elseif($say==5)
							{
								echo '<section id="m_'.$say.'" class="inner-section careers">';
								echo '<div class="content">
									<div class="text">
										<h3>'.$sal['name'].'</h3>
										<p class="section-text">
											'.$sal['body'].'
										</p>
										<button class="btn btn-default">More</button>
									</div>

									<div class="image">
										<img src="https://cdn.borgwarner.com/images/default-source/career/explore/special_career_explore_legal.jpg?sfvrsn=48a8ca3c_10">
									</div>
								</div>';
							}
							else
							{
								echo '<section id="m_'.$say.'" class="inner-section partners">';
								echo'<div class="inner-section">
									<h3>'.$sal['name'].'</h3>
									<div class="partners-container">';
									foreach($articles[$key][$say] as $bay=>$bal)
									{
										echo '<article class="partner">
												<!--<img src="http://www.plastrans.com/images/logo.png">-->
												<h4 class="partner-name">'.$bal['name'].'</h4>
												<p class="partner-info">'.$bal['body'].'</p>
												<a class="partner-link" href="http://'.$bal['url'].'/" target="_blank">
													'.$bal['url'].'
												</a>
											</article>';
									}
								echo'</div></div>	';
							}
							
						echo' </section>';
					}
				}
				elseif($key==6)
				{
					echo '<section id="m_'.$key.'" class="section products">';
					echo '<header class="section-header">
								<img class="brand" src="images/logo/svg/Polymer_Concept_sign.svg"/>
							</header>

							<section class="inner-section">
								<section id="about-products">
									<h3>'.$val['name'].'</h3>
									<p class="section-text">
										'.$val['body'].'
									</p>
								</section>
							<div class="wrapper">';
								foreach($categories[$key] as $say=>$sal)
								{
									echo '<div class="product-group">
										<p class="product-group-name">'.$sal['name'].'</p>
										<ul>';
											foreach($articles[$key][$say] as $bay=>$bal)
											{
												echo '<li class="product-name">'.$bal['name'].'</li>';
											}											
								  echo '</ul>
									</div>';
								}
					   echo'
							<div class="buttons-container text-center">
								<a href="#m_14" class="btn btn-default">
									Направи запитване
								</a>
							</div>
					   </div></section>';
					
				}
				elseif($key==13)
				{
					echo '<section id="m_'.$key.'" class="inner-section news">';
					echo'<div class="section-header">
							<h2>'.$val['name'].'</h2>
						</div>
						<div class="wrapper">';
						
						foreach($articless[$key] as $bay=>$bal)
						{
							echo'<article class="news-box">
									 <div class="date">
										<span class="day">'.$bal['day'].'</span>
										<span class="month">'.$bal['month'].'</span>
										<span class="year">'.$bal['year'].'</span>
									</div>
									<figure class="news-img">
										<img src="'.str_replace('..', '', $bal['pic']).'"/>
									</figure>

									<div class="news-text">
										<h4 class="news-headline">'.$bal['name'].'</h4>
										<p>'.$bal['body'].'</p>
									</div>
							</article>';
						}	
				  echo' </div>';
				}
				elseif($key==14)
				{
					echo '
					<section id="m_'.$key.'" class="wrapper contact">
					<section id="m_15" class="contact-us">

						<h2 class="">Запитване</h2>
					
						<div id="contacts"></div>
							<script type="text/javascript">
								<!--
									makeRequest(\'contacts.inc.php\', \'contacts\', false, false, false);
								-->
							</script>
					</section>

					<section id="m_17" class="locations">

						<div id="map-sofia"></div>


						<div class="wrapper inner-section">

							<header class="section-header">
								<h2 class="">Локации</h2>
							</header>

							<ul class="address-box">
								<li><h4>Офис и Склад  София</h4></li>
								<li>
								<span class="icon">
									<i class="fa fa-map-marker" aria-hidden="true"></i>
								</span>
									<p>гр. София, пк 1614</p>
									<p>ул.Борислав Огойски 1В</p>
								</li>
								<li>
										<span class="icon">
											<i class="fa fa-envelope" aria-hidden="true"></i>
										</span>
									<p>office@polymerconcept.bg</p>
								</li>
								<li>
										<span class="icon">
											<i class="fa fa-phone" aria-hidden="true"></i>
										</span>
									<p>+359 885 809 559</p>
								</li>
							</ul>
							<ul class="address-box">
								<li>
									<h4>Склад Пловдив</h4>
								</li>
								<li>
										<span class="icon">
											<i class="fa fa-map-marker" aria-hidden="true"></i>
										</span>
									<p>гр. Пловдив</p>
									<p>ул. Васил Левски 242А (Свободна Зона Пловдив)
										Склад 13 - Семела Логистикс</p>
								</li>
							</ul>
						</div>
					</section>';
				}
			echo' </section>';
		}
	?>
    
</main>

<footer>
    <div class="wrapper">
        <div class="copy">
            <p> &copy; 2018 Polymer Concept</p>
        </div>

        <div class="social">
            <a href="#"><i class="fa fa-facebook-official" aria-hidden="true"></i></a>
            <a href="#"><i class="fa fa-twitter-square"></i></a>
            <a href="#"><i class="fa fa-linkedin-square"></i></a>
            <a href="#"><i class="fa fa-instagram"></i></a>
        </div>


        <div class="created-by">
            <p> A web page by <a href="http://bky.bg" target="_blank" class="text-accent-secondary">BKY Solutions</a>
            </p>
        </div>
    </div>
</footer>

</body>
</html>
<script src="scripts/main.js"></script>
<script src="scripts/google-maps.js"></script>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDMUHqsddhmYBL1qc-OowEsvqo6rp2H4KE	&callback=initMap">
</script>