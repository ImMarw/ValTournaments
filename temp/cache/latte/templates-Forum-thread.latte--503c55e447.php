<?php

declare(strict_types=1);

use Latte\Runtime as LR;

/** source: /home/marw/PhpstormProjects/ValTournamentss/app/Presentation/Forum/templates/Forum/thread.latte */
final class Template_503c55e447 extends Latte\Runtime\Template
{
	public const Source = '/home/marw/PhpstormProjects/ValTournamentss/app/Presentation/Forum/templates/Forum/thread.latte';

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
			foreach (array_intersect_key(['post' => '14'], $this->params) as $ʟ_v => $ʟ_l) {
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

		echo '    <h2>';
		echo LR\Filters::escapeHtmlText($thread->title) /* line 4 */;
		echo '</h2>

';
		if ($user->isLoggedIn()) /* line 6 */ {
			echo '        <h4>Odpovědět</h4>
        ';
			$ʟ_tmp = $this->global->uiControl->getComponent('postForm');
			if ($ʟ_tmp instanceof Nette\Application\UI\Renderable) $ʟ_tmp->redrawControl(null, false);
			$ʟ_tmp->render() /* line 8 */;

			echo ' <!-- Move the form to the top -->
';
		} else /* line 9 */ {
			echo '        <p>Pro přidání odpovědi se přihlas.</p>
';
		}
		echo '
    <ul class="list-group mb-4">
';
		foreach ($posts as $post) /* line 14 */ {
			echo '            <li class="list-group-item">
                <strong>';
			echo LR\Filters::escapeHtmlText($post->username) /* line 16 */;
			echo ':</strong><br>
                ';
			echo LR\Filters::escapeHtmlText($post->content) /* line 17 */;
			echo '
            </li>
';

		}

		echo '    </ul>
';
	}
}
