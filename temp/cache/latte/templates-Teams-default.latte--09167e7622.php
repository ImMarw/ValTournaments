<?php

declare(strict_types=1);

use Latte\Runtime as LR;

/** source: /home/marw/PhpstormProjects/ValTournamentss/app/Presentation/Teams/templates/Teams/default.latte */
final class Template_09167e7622 extends Latte\Runtime\Template
{
	public const Source = '/home/marw/PhpstormProjects/ValTournamentss/app/Presentation/Teams/templates/Teams/default.latte';

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
			foreach (array_intersect_key(['team' => '6'], $this->params) as $ʟ_v => $ʟ_l) {
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

		echo '    <h2>Všechny týmy</h2>

    <div class="row">
';
		foreach ($teams as $team) /* line 6 */ {
			echo '            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <img src="/images/';
			echo LR\Filters::escapeHtmlAttr($team->logo) /* line 9 */;
			echo '" class="card-img-top" alt="';
			echo LR\Filters::escapeHtmlAttr($team->name) /* line 9 */;
			echo '">
                    <div class="card-body">
                        <h5 class="card-title">
                            <a href="';
			echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link('Teams:detail', ['id' => $team->id])) /* line 12 */;
			echo '">';
			echo LR\Filters::escapeHtmlText($team->name) /* line 12 */;
			echo '</a>
                        </h5>
                    </div>
                </div>
            </div>
';

		}

		echo '    </div>
';
	}
}
