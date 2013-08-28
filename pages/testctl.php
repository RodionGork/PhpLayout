<h3>Controllers</h3>

<p><b>Concept</b><br/>
Controller is the piece of code executed before rendering page. The purpose of this code is to prepare data, which page
should render.</p>

<p>One may ask - "But why could not data be prepared inside the page script itself?" - yes, it is possible since page
is PHP script either. However it is far better to separate this process.</p>

<p>So controller will be the piece of program without any html inside, taking care of fetching data from database etc. - while
page will contain mostly html with small amount of <code>if</code> and <code>foreach</code> statements and fields for
injecting data (like <code>&lt;?= $model->username ?&gt;</code>).</p>

<p><b>Example</b><br/>
Here is a list with data prepared as array in controller.
</p>
<ol>
<?php foreach ($model->lands as $land): ?>
    <li style="color:<?= $land->color ?>;font-weight:bold;"><?= $land->name ?></li>
<?php endforeach; ?>
</ol>

<p>Source of this controller is in <code>/ctl/Testctl.php</code> and page is in <code>/pages/testctl.php</code>.</p>

<p><b>Data exchange</b><br/>
Controller and page share predefined object <code>$model</code> - programmer is supposed to assign prepared data to its fields
and fetch these data from these fields inside the page.
</p>

<p><b>Controller file</b><br/>
Controller is placed in similar way with a corresponding page placement, though inside "ctl" folder instead of "pages" and
the file name starts with capital letter. I.e. if we have request like <code>index.php?page=clients_deals_list</code>, it
will be processed using controller from <code>/ctl/clients/deals/List.php</code> and the page from
<code>/pages/clients/deals/list.php</code>
</p>

<p>As you may note or guess already, if controller file is absent, no error occurs (if page does not require specially prepared data).
It is also possible to use controller without the corresponding page in cases when controller will redirect user to some
other page (for example after saving data received from the form) or will produce response itself (for example some json,
xml or binary data for robot).</p>

<p><b>Warning</b><br/>
However, it will not be good to put a lot of logic into controller. Controllers should be kept thin and tidy. For example
low-level reading tables from database etc. should be put into separate modules. We shall see how it is done in the next
section.
</p>

<p><a href="<?= url('modules') ?>">Next</a></p>
