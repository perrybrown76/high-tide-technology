<?php
$current      = basename($_SERVER['PHP_SELF']);
$servicePages = [
  'automated-protection.php', 'development.php', 'project-management.php',
  'cyber-security.php', 'naic-principles.php', 'when-not-if.php',
  'target-product-line.php', 'telecommunications.php', 'training.php',
];
$partnerPages = [
  'partnerships.php', 'adminbyrequest.php', 'amazon-web-services-1.php',
  'brocade.php', 'carbonite.php', 'cohesity.php', 'cybersaint-1.php',
  'cylance.php', 'datto.php', 'galileo.php', 'hbs.php', 'ketch.php',
  'malwarebytes.php', 'salvagedata.php', 'sentinel-one.php', 'vectra.php', 'qualys.php',
];
function navClass($page, $current) {
  return $current === $page ? ' class="active"' : '';
}
function navDropClass($pages, $current) {
  return in_array($current, $pages) ? ' class="nav-dropdown active"' : ' class="nav-dropdown"';
}
?>
  <header class="site-header">
    <nav class="nav-inner">
      <a href="index.php" class="nav-logo"><img src="assets/images/logo.png" alt="High Tide Technology"></a>
      <div class="nav-toggle"><span></span><span></span><span></span></div>
      <ul class="nav-links">
        <li><a href="index.php"<?= navClass('index.php', $current) ?>>Home</a></li>
        <li<?= navDropClass($servicePages, $current) ?>>
          <a href="services.php"<?= navClass('services.php', $current) ?>>Services</a>
          <ul>
            <li><a href="automated-protection.php"<?= navClass('automated-protection.php', $current) ?>>Automated Protection</a></li>
            <li><a href="development.php"<?= navClass('development.php', $current) ?>>Development</a></li>
            <li><a href="project-management.php"<?= navClass('project-management.php', $current) ?>>Project Management</a></li>
            <li><a href="cyber-security.php"<?= navClass('cyber-security.php', $current) ?>>Cyber Security</a></li>
            <li><a href="naic-principles.php"<?= navClass('naic-principles.php', $current) ?>>NAIC Principles</a></li>
            <li><a href="when-not-if.php"<?= navClass('when-not-if.php', $current) ?>>When, Not If</a></li>
            <li><a href="target-product-line.php"<?= navClass('target-product-line.php', $current) ?>>TARGET Product Line</a></li>
            <li><a href="telecommunications.php"<?= navClass('telecommunications.php', $current) ?>>Telecommunications</a></li>
            <li><a href="training.php"<?= navClass('training.php', $current) ?>>Training</a></li>
          </ul>
        </li>
        <li<?= navDropClass($partnerPages, $current) ?>>
          <a href="partnerships.php"<?= navClass('partnerships.php', $current) ?>>Partnerships</a>
          <ul>
            <li><a href="adminbyrequest.php"<?= navClass('adminbyrequest.php', $current) ?>>AdminByRequest</a></li>
            <li><a href="amazon-web-services-1.php"<?= navClass('amazon-web-services-1.php', $current) ?>>Amazon Web Services</a></li>
            <li><a href="brocade.php"<?= navClass('brocade.php', $current) ?>>Brocade</a></li>
            <li><a href="carbonite.php"<?= navClass('carbonite.php', $current) ?>>Carbonite</a></li>
            <li><a href="cohesity.php"<?= navClass('cohesity.php', $current) ?>>Cohesity</a></li>
            <li><a href="cybersaint-1.php"<?= navClass('cybersaint-1.php', $current) ?>>CyberSaint</a></li>
            <li><a href="cylance.php"<?= navClass('cylance.php', $current) ?>>Cylance</a></li>
            <li><a href="datto.php"<?= navClass('datto.php', $current) ?>>Datto</a></li>
            <li><a href="galileo.php"<?= navClass('galileo.php', $current) ?>>Galileo</a></li>
            <li><a href="hbs.php"<?= navClass('hbs.php', $current) ?>>HBS</a></li>
            <li><a href="ketch.php"<?= navClass('ketch.php', $current) ?>>Ketch</a></li>
            <li><a href="malwarebytes.php"<?= navClass('malwarebytes.php', $current) ?>>Malwarebytes</a></li>
            <li><a href="salvagedata.php"<?= navClass('salvagedata.php', $current) ?>>SalvageData</a></li>
            <li><a href="sentinel-one.php"<?= navClass('sentinel-one.php', $current) ?>>SentinelOne</a></li>
            <li><a href="vectra.php"<?= navClass('vectra.php', $current) ?>>Vectra</a></li>
            <li><a href="qualys.php"<?= navClass('qualys.php', $current) ?>>Qualys</a></li>
          </ul>
        </li>
        <li><a href="about-us.php"<?= navClass('about-us.php', $current) ?>>About</a></li>
        <li class="nav-cta"><a href="contact.php" class="btn btn-primary">Contact Us</a></li>
      </ul>
    </nav>
  </header>
