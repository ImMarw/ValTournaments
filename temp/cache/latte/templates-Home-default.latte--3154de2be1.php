<?php

declare(strict_types=1);

use Latte\Runtime as LR;

/** source: /home/marw/PhpstormProjects/ValTournamentss/app/Presentation/Home/templates/Home/default.latte */
final class Template_3154de2be1 extends Latte\Runtime\Template
{
	public const Source = '/home/marw/PhpstormProjects/ValTournamentss/app/Presentation/Home/templates/Home/default.latte';

	public const Blocks = [
		['content' => 'blockContent'],
	];


	public function main(array $ʟ_args): void
	{
		extract($ʟ_args);
		unset($ʟ_args);

		if ($this->global->snippetDriver?->renderSnippets($this->blocks[self::LayerSnippet], $this->params)) {
			return;
		}

		echo "\n";
		$this->renderBlock('content', get_defined_vars()) /* line 3 */;
	}


	public function prepare(): array
	{
		extract($this->params);

		if (!$this->getReferringTemplate() || $this->getReferenceType() === 'extends') {
			foreach (array_intersect_key(['tournament' => '14, 36'], $this->params) as $ʟ_v => $ʟ_l) {
				trigger_error("Variable \$$ʟ_v overwritten in foreach on line $ʟ_l");
			}
		}
		$this->parentName = '../../../templates/@layout.latte';
		return get_defined_vars();
	}


	/** {block content} on line 3 */
	public function blockContent(array $ʟ_args): void
	{
		extract($this->params);
		extract($ʟ_args);
		unset($ʟ_args);

		echo '    <div class="container py-5">
        <div class="text-center mb-5">
            <h1 class="display-4 fw-bold">Valorant Turnaje</h1>
            <p class="lead">Vítej na Valorant Turnajích. Tato stránka slouží jako přehled všech online Valorant turnajů. Sleduj nadcházející zápasy, registruj se svým týmem a získej skvělé ceny!</p>
        </div>

        <div class="row">
            <!-- Left Column for Upcoming Tournaments -->
            <div class="col-md-6">
                <h3 class="text-primary text-center mb-4">Nejnovější nadcházející turnaje</h3>
';
		foreach ($upcoming as $tournament) /* line 14 */ {
			echo '                    <div class="card shadow-sm border-0 mb-4">
                        <div class="row g-0">
                            <div class="col-8 p-3">
                                <div class="text-primary small fw-bold mb-1"><i class="bi bi-stopwatch"></i> Začátek</div>
                                <h5 class="card-title mb-2 fw-bold">
                                    <a href="';
			echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link('Tournament:detail', [$tournament->id])) /* line 20 */;
			echo '" class="tournament-title-link text-decoration-none text-primary">';
			echo LR\Filters::escapeHtmlText($tournament->name) /* line 20 */;
			echo '</a>
                                </h5>
                                <div class="small text-muted"><i class="bi bi-calendar-event"></i> ';
			echo LR\Filters::escapeHtmlText(($this->filters->date)($tournament->start_time, 'j. n. Y H:i')) /* line 22 */;
			echo '</div>
                                <div class="small text-muted"><i class="bi bi-globe"></i> Region: ';
			echo LR\Filters::escapeHtmlText($tournament->region) /* line 23 */;
			echo '</div>
                            </div>
                            <div class="col-4 d-flex align-items-center justify-content-center bg-light rounded-end">
                                <img src="/images/flags/';
			echo LR\Filters::escapeHtmlAttr(($this->filters->lower)($tournament->region)) /* line 26 */;
			echo '.svg" alt="';
			echo LR\Filters::escapeHtmlAttr($tournament->region) /* line 26 */;
			echo '" class="img-fluid">
                            </div>
                        </div>
                    </div>
';

		}

		echo '            </div>

            <!-- Right Column for Completed Tournaments -->
            <div class="col-md-6">
                <h3 class="text-muted text-center mb-4">Nejnovější dokončené turnaje</h3>
';
		foreach ($finished as $tournament) /* line 36 */ {
			echo '                    <div class="card shadow-sm border-0 mb-4">
                        <div class="row g-0">
                            <div class="col-8 p-3">
                                <div class="text-muted small fw-bold mb-1"><i class="bi bi-check-circle"></i> Dokončeno</div>
                                <h5 class="card-title mb-2 fw-bold">
                                    <a href="';
			echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link('Tournament:detail', [$tournament->id])) /* line 42 */;
			echo '" class="tournament-title-link text-decoration-none text-dark">';
			echo LR\Filters::escapeHtmlText($tournament->name) /* line 42 */;
			echo '</a>
                                </h5>
                                <div class="small text-muted"><i class="bi bi-calendar-check"></i> Start: ';
			echo LR\Filters::escapeHtmlText(($this->filters->date)($tournament->start_time, 'j. n. Y H:i')) /* line 44 */;
			echo '</div>
                                <div class="small text-muted"><i class="bi bi-globe"></i> Region: ';
			echo LR\Filters::escapeHtmlText($tournament->region) /* line 45 */;
			echo '</div>
                            </div>
                            <div class="col-4 d-flex align-items-center justify-content-center bg-light rounded-end">
                                <img src="/images/flags/';
			echo LR\Filters::escapeHtmlAttr(($this->filters->lower)($tournament->region)) /* line 48 */;
			echo '.svg" alt="';
			echo LR\Filters::escapeHtmlAttr($tournament->region) /* line 48 */;
			echo '" class="img-fluid">
                            </div>
                        </div>
                    </div>
';

		}

		echo '            </div>
        </div>
    </div>
';
	}
}
