<?php	
    //Sistem Pendukung Keputusan (SPK) Metode Analytic Hierarchy Process (AHP) Menggunakan Bahasa Pemrograman PHP
    //© 2019 ContohProgram.com
	//email : contohprogram.com@gmail.com
	//web : http://contohprogram.com
	$cb = array("-", "+", "+", "+", "+", "+");	
					   //kriteria  K1,  K2, K3, K4,  K5,  K6
	$x = array(                                                //alternatif
							array(3500, 70, 10, 80, 3000, 36),	//A1								
							array(4500, 90, 10, 60, 2500, 48),	//A2					                           
							array(4000, 80, 9, 90, 2000, 48),	//A3												                            
							array(4000, 70, 8, 50, 1500, 60)	//A4
						  );
					   //kriteria K1,          K2,K3,K4,K5,          K6
	$k = array(                                                                     //kriteria
							array(1,           5, 5, 5, 3,           3),	        //K1								
							array(0.2,         1, 1, 1, 0.333333333, 0.333333333),	//K2					                           
							array(0.2,         1, 1, 1, 0.333333333, 0.333333333),	//K3												                            
							array(0.2,         1, 1, 1, 0.333333333, 0.333333333),	//K4												                            
							array(0.333333333, 3, 3, 3, 1,           1),	        //K5
							array(0.333333333, 3, 3, 3, 1,           1)	            //K6
						  );
	$jk = array();
	for ($i=0;$i<count($x[0]);$i++)
	{
		$jk[$i]=0;
		for ($j=0;$j<count($x[0]);$j++)
		{			
			$jk[$i] += $k[$j][$i];
		}
	}
	$nk = array();
	for ($i=0;$i<count($x[0]);$i++)
	{
		for ($j=0;$j<count($x[0]);$j++)
		{			
			$nk[$i][$j] = $k[$i][$j] / $jk[$j];
		}
	}
	$jnk = array();
	for ($i=0;$i<count($x[0]);$i++)
	{
		$jnk[$i] = 0;
		for ($j=0;$j<count($x[0]);$j++)
		{			
			$jnk[$i] += $nk[$i][$j]; 
		}
	}
	$w = array();
	for ($i=0;$i<count($x[0]);$i++)
	{
		$w[$i] = $jnk[$i] / count($x[0]); 
	}
	$kw = array();
	for ($i=0;$i<count($x[0]);$i++)
	{
		$kw[$i] = 0;
		for ($j=0;$j<count($x[0]);$j++)
		{			
			$kw[$i] += $k[$i][$j] * $w[$j]; 
		}
	}
	$t=0;
	for ($i=0;$i<count($x[0]);$i++)
	{
		$t += $kw[$i] / $w[$i]; 
	}
	$t = $t / count($x[0]);
	$ci = ($t - count($x[0])) / (count($x[0]) - 1);
	if (count($x[0]) == 3)
    {
		$ri = 0.58;
	}
	else if (count($x[0]) == 4)
	{
		$ri = 0.9;
	}
	else if (count($x[0]) == 5)
	{
		$ri = 1.12;
	}
	else if (count($x[0]) == 6)
	{
		$ri = 1.24;
	}
	else if (count($x[0]) <= 2)
	{
		$ri = 0.01;
	}
	else 
	{
		$ri = 1.32;
	}	
	$cr = $ci / $ri;
	$nmin = array();
	for ($i=0;$i<count($x[0]);$i++)
	{
		$nmin[$i] = 1000000;
		
		if ($cb[$i] == "-")
		{
			for ($j=0;$j<count($x);$j++)
			{	
				if ($nmin[$i] > $x[$j][$i])
				{
					$nmin[$i] = $x[$j][$i];
				}		
			}
		}
		else
		{
			$nmin[$i] = -1000000;
		
			for ($j=0;$j<count($x);$j++)
			{	
				if ($nmin[$i] < $x[$j][$i])
				{
					$nmin[$i] = $x[$j][$i];
				}
			}
		}
	}
	$mnkr = array();
	for ($i=0;$i<count($x);$i++)
	{
		for ($j=0;$j<count($x[0]);$j++)
		{			
			if ($cb[$j] == "-")
			{
				$mnkr[$i][$j] = $nmin[$j] / $x[$i][$j]; 
			}
			else
			{
				$mnkr[$i][$j] = $x[$i][$j] / $nmin[$j]; 
			}
		}
	}
	$jmn = array();
	for ($i=0;$i<count($x[0]);$i++)
	{
		$jmn[$i] = 0;
		for ($j=0;$j<count($x);$j++)
		{			
			$jmn[$i] = $jmn[$i] + $mnkr[$j][$i];
		}
	}
	$nrmn = array();
	for ($i=0;$i<count($x);$i++)
	{
		for ($j=0;$j<count($x[0]);$j++)
		{			
				$nrmn[$i][$j] = $mnkr[$i][$j] / $jmn[$j]; 
		}
	}
	$hsl = array();
	for ($i=0;$i<count($x);$i++)
	{
		$hsl[$i] = 0;
		for ($j=0;$j<count($x[0]);$j++)
		{			
			$hsl[$i] += $nrmn[$i][$j] * $w[$j]; 
		}
		echo $hsl[$i]."<br/>";
	}
	echo '<br/>';
	echo '<a href="http://contohprogram.com/demo/ahp-php/ahp-php-mysql.php">Demo Lengkap AHP-PHP-MYSQL di http://contohprogram.com</a>';
	echo '<br/>';
	echo '<a href="http://contohprogram.com/demo/ahp-php-mysqli-bootstrap/ahp-php-mysql.php">Demo Lengkap AHP-PHP-MYSQLI-BOOTSTRAP di http://contohprogram.com</a>';
	echo '<br/>';
	echo 'untuk mendapatkan source code lengkap, hubungi contohprogram.com@gmail.com';
?>