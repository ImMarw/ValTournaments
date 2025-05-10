<?php

declare(strict_types=1);

use Latte\Runtime as LR;

/** source: /home/marw/PhpstormProjects/ValTournamentss/app/Presentation/Forum/templates/Forum/default.latte */
final class Template_1554628199 extends Latte\Runtime\Template
{
	public const Source = '/home/marw/PhpstormProjects/ValTournamentss/app/Presentation/Forum/templates/Forum/default.latte';

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
			foreach (array_intersect_key(['thread' => '12'], $this->params) as $ʟ_v => $ʟ_l) {
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
        <h1 class="display-4 text-center mb-5">Fórum</h1>

';
		if ($user->isLoggedIn()) /* line 7 */ {
			echo '            <a href="';
			echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link('Forum:createThread')) /* line 8 */;
			echo '" class="btn btn-primary mb-4">➕ Nové vlákno</a>
';
		}
		echo '
        <div class="list-group">
';
		foreach ($threads as $thread) /* line 12 */ {
			echo '                <div class="list-group-item d-flex justify-content-between align-items-center">
                    <a href="';
			echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link('Forum:thread', ['id' => $thread->id])) /* line 14 */;
			echo '" class="text-decoration-none text-dark">
                        <h5 class="mb-1">';
			echo LR\Filters::escapeHtmlText($thread->title) /* line 15 */;
			echo '</h5>
                    </a>
                    <small class="text-muted">Posted on: ';
			echo LR\Filters::escapeHtmlText(($this->filters->date)($thread->created_at, 'j. n. Y')) /* line 17 */;
			echo '</small>
                </div>
';

		}

		echo '        </div>
    </div>
';
	}
}
