<?php
$ctx->elems->layout = 'alternate';
?>

<h3>Specific layout</h3>

<p>
This page demonstrates how layout could be selected from inside the page itself using
<code>$ctx-&gt;elems-&gt;layout = 'layoutname';</code> construction.
</p>

<p>Examining this page's source you will find that it uses layout named "alternate", if you
open it from folder "layouts", you'll see that it is shorter than default layout because it
intentionally lacks header or footer.</p>

<p>
<b>Internal links</b><br/>
Other important thing to note is that to create internal link to one of the pages it is important
to use <code>url('pagename')</code> special function. It will generate proper link depending on
whether url rewriting is turned on or not.
</p>

<p>An example of the link could be seen in each page source as "next" link (at the last line), or "to main page"
link in "alternate" layout (you see it rendered on this page).</p>

<p><a href="<?= url('testctl') ?>">Next</a></p>

