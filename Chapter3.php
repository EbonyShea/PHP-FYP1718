<?php
	include_once 'includes/dashheader.php';
?>

<section id = "parent-container">
	<div class = "content-container">
		<div id = "lesson-container">
			<a class = "btn btn-info" href = "lesson.php">Return</a>
			</br>
			<h1>Chapter 3: Latches</h1>
			<hr>
			<h1>SR-latch</h1>
			</br>
			<p>An SR latch (Set/Reset) is an asynchronous device: it works independently of control signals and relies only on the state of the S and R inputs. In the image we can see that an SR flip-flop can be created with two NOR gates that have a cross-feedback loop. SR latches can also be made from NAND gates, but the inputs are swapped and negated.</p>
			<img src = "img/lesson/Chapter3/1.png"/>
			</br></br>
			<p>When a high is applied to the Set line of an SR latch, 
			the Q output goes high (and Q low). The feedback mechanism, 
			however, means that the Q output will remain high, 
			even when the S input goes low again. 
			This is how the latch serves as a memory device. 
			Conversely, a high input on the Reset line will drive the Q output low (and Q high), 
			effectively resetting the latch's "memory". When both inputs are low, the latch "latches" – 
			it remains in its previously set or reset state.</p>
			</br></br>
			<p>When both inputs are high at once, however, there is a problem: 
			it is being told to simultaneously produce a high Q and a low Q. 
			This produces a "race condition" within the circuit - whichever flip flop succeeds 
			in changing first will feedback to the other and assert itself. Ideally, both 
			gates are identical and this is "metastable", and the device will be in an 
			undefined state for an indefinite period. In real life, due to manufacturing 
			methods, one gate will always win, but it's impossible to tell which it will 
			be for a particular device from an assembly line. The state of S = R = 1 is 
			therefore "illegal" and should never be entered.</p>
			</br></br>
			<p>When the device is powered up, a similar condition occurs, 
			because both outputs, Q and Q, are low. Again, the device will quickly 
			exit the metastable state due to differences between the two gates, 
			but it's impossible to predict which of Q and Q will end up high. 
			To avoid spurious actions, you should always set SR flip-flops to a 
			known initial state before using them - you must not assume that they will initialize to a low state.</p>
			</br></br>
			<img src = "img/lesson/Chapter3/2.png"/>
			<img src = "img/lesson/Chapter3/3.png"/>
			</br></br>
			<hr>
			<h1>D-latch</h1>
			</br>
			<p>The D latch (D for "data") or transparent latch is a simple extension of the gated SR latch that removes the possibility of invalid input states.</p>
			</br></br>
			<p>Since the gated SR latch allows us to latch the output without using the S or R inputs, we can remove one of the inputs by driving both the Set and Reset inputs with a complementary driver: we remove one input and automatically make it the inverse of the remaining input.</p>
			</br></br>
			<p>The D latch outputs the D input whenever the Enable line is high, otherwise the output is whatever the D input was when the Enable input was last high. This is why it is also known as a transparent latch - when Enable is asserted, the latch is said to be "transparent" - it signals propagate directly through it as if it isn't there.</p>
			<img src = "img/lesson/Chapter3/4.png"/>
			<img src = "img/lesson/Chapter3/5.png"/>
		</div>
	</div>
</section>

</div>
</body>
</html>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-113639948-2"></script>

<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-113639948-2');
</script>