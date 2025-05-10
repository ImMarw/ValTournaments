<?php

declare(strict_types=1);

use Latte\Runtime as LR;

/** source: /home/marw/PhpstormProjects/ValTournamentss/app/Presentation/templates/@layout.latte */
final class Template_98ad8f2c5e extends Latte\Runtime\Template
{
	public const Source = '/home/marw/PhpstormProjects/ValTournamentss/app/Presentation/templates/@layout.latte';

	public const Blocks = [
		['scripts' => 'blockScripts'],
	];


	public function main(array $ʟ_args): void
	{
		extract($ʟ_args);
		unset($ʟ_args);

		if ($this->global->snippetDriver?->renderSnippets($this->blocks[self::LayerSnippet], $this->params)) {
			return;
		}

		echo '<!DOCTYPE html>
<html lang="cs">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>';
		if ($this->hasBlock('title')) /* line 6 */ {
			$this->renderBlock('title', [], function ($s, $type) {
				$ʟ_fi = new LR\FilterInfo($type);
				return LR\Filters::convertTo($ʟ_fi, 'html', $this->filters->filterContent('stripHtml', $ʟ_fi, $s));
			}) /* line 6 */;
			echo ' | ';
		}
		echo 'Valorant Turnaje</title>

	<!-- Bootstrap + Icons -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
	<link href="';
		echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 11 */;
		echo '/css/style.css" rel="stylesheet">

	<style>
		body {
			background-color: #f8f9fa;
			color: #212529;
		}
		.navbar {
			box-shadow: 0 2px 4px rgba(0,0,0,0.1);
			background-color: #343a40;
		}
		.nav-link {
			font-weight: 500;
		}
		.nav-link:hover {
			color: #0d6efd;
		}
		.navbar-brand {
			font-weight: bold;
			color: white;
		}
		.navbar-nav .nav-link {
			color: white;
		}
		.navbar-nav .nav-link:hover {
			color: #0d6efd;
		}
		.navbar-toggler {
			border-color: rgba(255,255,255,.1);
		}
		.navbar-toggler-icon {
			background-color: white;
		}
		.search-icon, .profile-icon {
			color: white;
		}
		.flash {
			margin: 1rem auto;
			padding: 1rem 1.5rem;
			border-radius: .25rem;
			max-width: 960px;
		}
		.flash.success {
			background-color: #d1e7dd;
			color: #0f5132;
		}
		.flash.error {
			background-color: #f8d7da;
			color: #842029;
		}
	</style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark">
	<div class="container">
		<a href="';
		echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link('Home:default')) /* line 66 */;
		echo '" class="navbar-brand">Valorant Turnaje</a>
		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarNav">
			<ul class="navbar-nav me-auto mb-2 mb-lg-0">
				<li class="nav-item">
					<a href="';
		echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link('Home:default')) /* line 74 */;
		echo '" class="nav-link">
						<i class="bi bi-house-door"></i> Domů
					</a>
				</li>
				<li class="nav-item">
					<a href="';
		echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link('Tournament:default')) /* line 79 */;
		echo '" class="nav-link">
						<i class="bi bi-trophy"></i> Turnaje
					</a>
				</li>
				<li class="nav-item">
					<a href="';
		echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link('Teams:default')) /* line 84 */;
		echo '" class="nav-link">
						<i class="bi bi-person-lines-fill"></i> Týmy
					</a>
				</li>
				<li class="nav-item">
					<a href="';
		echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link('Forum:default')) /* line 89 */;
		echo '" class="nav-link">
						<i class="bi bi-chat-square-text"></i> Fórum
					</a>
				</li>
			</ul>

			<ul class="navbar-nav">
';
		if ($user->isLoggedIn()) /* line 96 */ {
			echo '					<li class="nav-item">
						<span class="nav-link"><i class="bi bi-person-circle profile-icon"></i> ';
			echo LR\Filters::escapeHtmlText($user->identity->username) /* line 98 */;
			echo '</span>
					</li>
					<li class="nav-item">
						<a href="';
			echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link('Sign:out')) /* line 101 */;
			echo '" class="nav-link">
							<i class="bi bi-box-arrow-right"></i> Odhlásit
						</a>
					</li>
';
		} else /* line 105 */ {
			echo '					<li class="nav-item">
						<a href="';
			echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link('Sign:login')) /* line 107 */;
			echo '" class="nav-link">
							<i class="bi bi-box-arrow-in-right"></i> Přihlásit
						</a>
					</li>
					<li class="nav-item">
						<a href="';
			echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link('Sign:register')) /* line 112 */;
			echo '" class="nav-link">
							<i class="bi bi-person-add"></i> Registrovat
						</a>
					</li>
';
		}
		echo '				<li class="nav-item">
					<a href="';
		echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link('Team:default')) /* line 118 */;
		echo '" class="nav-link">
						<i class="bi bi-person-plus"></i> Vytvořit Tým
					</a>
				</li>
			</ul>
		</div>
	</div>
</nav>

<main class="container mb-5">
';
		foreach ($flashes as $flash) /* line 128 */ {
			echo '	<div';
			echo ($ʟ_tmp = array_filter(['flash', $flash->type])) ? ' class="' . LR\Filters::escapeHtmlAttr(implode(" ", array_unique($ʟ_tmp))) . '"' : "" /* line 128 */;
			echo '>';
			echo LR\Filters::escapeHtmlText($flash->message) /* line 128 */;
			echo '</div>
';

		}

		$this->renderBlock('content', [], 'html') /* line 129 */;
		echo '</main>

';
		$this->renderBlock('scripts', get_defined_vars()) /* line 132 */;
		echo '</body>
</html>
';
	}


	public function prepare(): array
	{
		extract($this->params);

		if (!$this->getReferringTemplate() || $this->getReferenceType() === 'extends') {
			foreach (array_intersect_key(['flash' => '128'], $this->params) as $ʟ_v => $ʟ_l) {
				trigger_error("Variable \$$ʟ_v overwritten in foreach on line $ʟ_l");
			}
		}
		return get_defined_vars();
	}


	/** {block scripts} on line 132 */
	public function blockScripts(array $ʟ_args): void
	{
		echo '	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
	<script src="https://unpkg.com/nette-forms@3"></script>
';
	}
}
