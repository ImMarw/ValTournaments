<?php

declare(strict_types=1);

use Latte\Runtime as LR;

/** source: /home/marw/PhpstormProjects/ValTournamentss/app/Presentation/Tournament/templates/Tournament/default.latte */
final class Template_5a0c4c89ac extends Latte\Runtime\Template
{
	public const Source = '/home/marw/PhpstormProjects/ValTournamentss/app/Presentation/Tournament/templates/Tournament/default.latte';

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

		$this->renderBlock('content', get_defined_vars()) /* line 2 */;
	}


	public function prepare(): array
	{
		extract($this->params);

		if (!$this->getReferringTemplate() || $this->getReferenceType() === 'extends') {
			foreach (array_intersect_key(['tournament' => '9'], $this->params) as $ʟ_v => $ʟ_l) {
				trigger_error("Variable \$$ʟ_v overwritten in foreach on line $ʟ_l");
			}
		}
		$this->parentName = '../../../templates/@layout.latte';
		return get_defined_vars();
	}


	/** {block content} on line 2 */
	public function blockContent(array $ʟ_args): void
	{
		extract($this->params);
		extract($ʟ_args);
		unset($ʟ_args);

		echo '    <div class="container py-5">
        <div class="text-center mb-5">
            <h1 class="display-4 fw-bold">Turnaje</h1>
        </div>

        <div class="row row-cols-1 row-cols-md-2 g-4">
';
		foreach ($tournaments as $tournament) /* line 9 */ {
			echo '                <div class="col">
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="row g-0">
                            <div class="col-8 p-3">
                                <div class="text-muted small fw-bold mb-1"><i class="bi bi-check-circle"></i> Dokončeno</div>
                                <h5 class="card-title mb-2 fw-bold">
                                    <a href="';
			echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link('Tournament:detail', [$tournament->id])) /* line 16 */;
			echo '" class="tournament-title-link text-decoration-none text-dark">';
			echo LR\Filters::escapeHtmlText($tournament->name) /* line 16 */;
			echo '</a>
                                </h5>
                                <div class="small text-muted"><i class="bi bi-calendar-check"></i> Start: ';
			echo LR\Filters::escapeHtmlText(($this->filters->date)($tournament->start_time, 'j. n. Y H:i')) /* line 18 */;
			echo '</div>
                                <div class="small text-muted"><i class="bi bi-globe"></i> Region: ';
			echo LR\Filters::escapeHtmlText($tournament->region) /* line 19 */;
			echo '</div>
                            </div>
                            <div class="col-4 d-flex align-items-center justify-content-center bg-light rounded-end">
                                <img src="/images/flags/';
			echo LR\Filters::escapeHtmlAttr(($this->filters->lower)($tournament->region)) /* line 22 */;
			echo '.svg" alt="';
			echo LR\Filters::escapeHtmlAttr($tournament->region) /* line 22 */;
			echo '" class="img-fluid">
                            </div>
                        </div>
                    </div>
                </div>
';

		}

		echo '        </div>
    </div>
';
	}
}
