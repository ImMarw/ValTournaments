<?php

declare(strict_types=1);

use Latte\Runtime as LR;

/** source: /home/marw/PhpstormProjects/ValTournamentss/app/Presentation/Forum/templates/Forum/postReply.latte */
final class Template_f4b4746c98 extends Latte\Runtime\Template
{
	public const Source = '/home/marw/PhpstormProjects/ValTournamentss/app/Presentation/Forum/templates/Forum/postReply.latte';

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

		$this->parentName = '../../../templates/@layout.latte';
		return get_defined_vars();
	}


	/** {block content} on line 3 */
	public function blockContent(array $ʟ_args): void
	{
		extract($this->params);
		extract($ʟ_args);
		unset($ʟ_args);

		echo '    <h2>Odpověď odeslána</h2>
    <p>Vaše odpověď byla úspěšně odeslána a je viditelná na fóru.</p>
    <a href="';
		echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link('Forum:thread', ['id' => $thread->id])) /* line 6 */;
		echo '" class="btn btn-primary">Zpět na vlákno</a>
';
	}
}
