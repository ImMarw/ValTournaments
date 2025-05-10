<?php

declare(strict_types=1);

use Latte\Runtime as LR;

/** source: /home/marw/PhpstormProjects/ValTournamentss/app/Presentation/Tournament/templates/Tournament/detail.latte */
final class Template_2f09f89cc8 extends Latte\Runtime\Template
{
	public const Source = '/home/marw/PhpstormProjects/ValTournamentss/app/Presentation/Tournament/templates/Tournament/detail.latte';

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
			foreach (array_intersect_key(['match' => '28'], $this->params) as $ʟ_v => $ʟ_l) {
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
        <div class="card border border-2 border-dark shadow-sm mb-5">
            <div class="row g-0">
                <div class="col-md-4 bg-light">
                    <img src="/images/';
		echo LR\Filters::escapeHtmlAttr($tournament->image) /* line 7 */;
		echo '" class="img-fluid rounded-start w-100 h-100 object-fit-cover" alt="';
		echo LR\Filters::escapeHtmlAttr($tournament->name) /* line 7 */;
		echo '">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h2 class="card-title fw-bold mb-3">
                            <i class="bi bi-trophy-fill text-warning me-2"></i>';
		echo LR\Filters::escapeHtmlText($tournament->name) /* line 12 */;
		echo '
                        </h2>
                        <p class="mb-2"><i class="bi bi-globe2 me-2"></i><strong>Region:</strong> ';
		echo LR\Filters::escapeHtmlText($tournament->region) /* line 14 */;
		echo '</p>
                        <p class="mb-0"><i class="bi bi-calendar-event me-2"></i><strong>Začátek:</strong> ';
		echo LR\Filters::escapeHtmlText(($this->filters->date)($tournament->start_time, 'j. n. Y H:i')) /* line 15 */;
		echo '</p>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <h3 class="mb-4 fw-semibold">
                <i class="bi bi-controller text-danger me-2"></i>Zápasy
            </h3>

';
		if (count($matches)) /* line 26 */ {
			echo '                <ul class="list-group border border-2 rounded border-dark">
';
			foreach ($matches as $match) /* line 28 */ {
				echo '                        <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>
                            <i class="bi bi-person-fill me-2"></i>Tým #';
				echo LR\Filters::escapeHtmlText($match->team1_id) /* line 31 */;
				echo ' vs Tým #';
				echo LR\Filters::escapeHtmlText($match->team2_id) /* line 31 */;
				echo '
                        </span>
                            <span class="text-muted"><i class="bi bi-clock me-1"></i>';
				echo LR\Filters::escapeHtmlText(($this->filters->date)($match->match_time, 'j. n. Y H:i')) /* line 33 */;
				echo '</span>
                        </li>
';

			}

			echo '                </ul>
';
		} else /* line 37 */ {
			echo '                <div class="alert alert-info border border-info">
                    <i class="bi bi-info-circle me-2"></i>Žádné zápasy zatím nebyly přidány.
                </div>
';
		}
		echo '        </div>
    </div>
';
	}
}
