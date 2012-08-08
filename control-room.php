<?php if ( !defined( 'STUZZPANEL' ) ) exit; ?>
<section>
<h2>Start</h2>
<p>Starts the server. This may take a few minutes, especially if it is the first time the server has started. </p>
<button disabled class="btn">Already running</button>
</section>
<hr>
<section>
<h2>Stop</h2>
<p>Sends the command <tt>stop</tt> to the server console. This is generally the safest way to shut down the server.</p>
<button class="btn btn-primary">Stop server</button>
</section>
<hr>
<section>
<h2>Terminate</h2>
<p>Asks the server to shut down by sending it a <code>SIGTERM</code>. This still allows the server to save maps and players, but does not require the console to be responding. This can damage data in rare cases.</p>
<button class="btn btn-warning">Terminate server</button>
</section>
<hr>
<section>
<h2>DANGER ZONE</h2>
<p>Immediately kills the server by sending <code>SIGKILL</code>. The server does not get a chance to shut down gracefully. You are very likely to corrupt your data if you use this, especially if it is in the middle of being saved. StuzzHosting is not responsible for anything that happens as a result of you clicking this button.</p>
<button class="btn btn-danger">YOU WILL REGRET CLICKING THIS BUTTON</button>
</section>
