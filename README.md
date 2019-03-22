<p align="center">
    <img src="https://raw.githubusercontent.com/Thibok/snowTricks/develop/web/img/logo.png"/>
</p>
<a href="https://www.codacy.com/app/Thibok/snowTricks?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=Thibok/snowTricks&amp;utm_campaign=Badge_Grade"><img src="https://api.codacy.com/project/badge/Grade/11d44f0b76d74f15b4ed1b0ccbc7d957"/></a>
<p>Welcome on the SnowTricks project ! This project was realized under <strong>Symfony 3.4</strong>.
This project is for my training at Openclassroom on the DA PHP/Symfony path.This is my sixth project, for wich i  need to create a snowboard community site under <strong>Symfony</strong></p>
<h2>Prerequisites</h2>
<ul>
  <li>PHP 7</li>
  <li>Mysql</li>
  <li>Apache</li>
</ul>
<h2>Libraries</h2>
<ul>
  <li>Bootstrap</li>
  <li>JQuery</li>
</ul>
<h2>Framework</h2>
<ul>
  <li>Symfony</li>
</ul>
<h2>ORM</h2>
<ul>
  <li>Doctrine</li>
</ul>
<h2>Bundles</h2>
<ul>
  <li>Doctrine Fixtures Bundle</li>
  <li>Assetic</li>
</ul>
<h2>Installation</h2>
<h4>Clone project :</h4>
<pre>git clone https://github.com/Thibok/snowTricks.git</pre>
<h4>Install dependencies :</h4>
<pre>compoer install</pre>
<h4>Create database :</h4>
<pre>php bin/console doctrine:database:create</pre>
<h4>Update schema :</h4>
<pre>php bin/console doctrine:schema:update --force</pre>
<h4>Create uploads folders :</h4>
<pre>mkdir -p web/uploads/img/trick</pre>
<pre>mkdir web/uploads/img/user</pre>
<h4>Update captcha public key :</h4>
<p>Go in app/Ressources/views/macros/form_elements.html.twig and set your captcha public key in data-sitekey</p>
<h4>Install assets</h4>
<pre>php bin/console assets:install --symlink</pre>
<h4>Load fixtures :</h4>
<pre>php bin/console doctrine:fixture:load</pre>
<h4>Run It !</h4>
<p>Now you can start your server with this :</p>
<pre>php bin/console server:start</pre>
<strong>And go on the local address !</strong>
<h2>Tests</h2>
<p>If you need run tests :</p> 
<h4>Create test database :</h4>
<pre>php bin/console doctrine:database:create --env=test</pre>
<h4>Update schema :</h4>
<pre>php bin/console doctrine:schema:update --force --env=test</pre>
<h4>Create uploads test folders :</h4>
<pre>mkdir -p web/uploads/img/tests/trick</pre>
<pre>mkdir web/uploads/img/tests/user</pre>
<h4>Load test fixtures :</h4>
<pre>php bin/console doctrine:fixture:load --env="test"</pre>
<h4>Run tests !</h4>
<pre>vendor/bin/phpunit</pre>
<h2>Production</h2>
<p>If you want to use production environment, don't forget :</p>
<h4>Clear cache :</h4>
<pre>php bin/console cache:clear --env="prod"</pre>
<h4>Dump assets :</h4>
<pre>php bin/console assetic:dump --env="prod"</pre>
