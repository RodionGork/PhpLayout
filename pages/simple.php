<?php $ctx->elems->title = 'Simple layout features'; ?>

<h3>Simple page</h3>


<p>
<b>Static pages handling</b><br/>
This is a demo for handling simple static pages. Open file <code>/pages/simple.php</code> to view the source of this page.
</p>

<p>As you can see, any url like <code>index.php?page=simple</code> is usually represented by the file with the same name
and extension ".php" inside "pages" folder.</p>

<p>There could be subfolders also, so that url like <code>index.php?page=clients_deals_list</code> will fetch the file
<code>/pages/clients/deals/list.php</code> - i.e. underscores are used instead of slashes.</p>

<p>If you want to use mod_rewrite to make urls more beautiful, the project is ready for it (thanks to provided .htaccess file) -
simply change corresponding line in conf.php in the root folder (make it <code>Elems::$elems->conf->modrewrite = false;</code>).</p>

<p>
<b>Layout concept</b><br/>
You may note that page source file does not contain head, menu or footer - only the fragment between them. This is the
conception of "layout": pages provide only their core content and all decorations are put into separate file, which is
added "around" the page when rendering.
</p>

<p>By default <code>/layouts/default.html</code> file is used, but it could be changed
from inside the page itself. Layout elements (like header, footer, included scripts and styles) could be also controlled
from the page.
</p>

<p>For example you can see that the title of this page is changed by the first line in the corresponding file.</p>

<p>Also peeking in the layout file you can find that small fragments could be inserted into page or
layout with the help of <code>$ctx->util->fragment('somename')</code> construction - this will fetch the piece from
the folder <code>/fragments/somename.html</code> and insert it into current position.
</p>

<p><a href="<?= url('special') ?>">Next</a></p>
