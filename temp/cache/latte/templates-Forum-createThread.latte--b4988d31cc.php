<?php

declare(strict_types=1);

use Latte\Runtime as LR;

/** source: /home/marw/PhpstormProjects/ValTournamentss/app/Presentation/Forum/templates/Forum/createThread.latte */
final class Template_b4988d31cc extends Latte\Runtime\Template
{
	public const Source = '/home/marw/PhpstormProjects/ValTournamentss/app/Presentation/Forum/templates/Forum/createThread.latte';

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

		$this->parentName = '../../../templates/@layout.latte';
		return get_defined_vars();
	}


	/** {block content} on line 2 */
	public function blockContent(array $ʟ_args): void
	{
		extract($this->params);
		extract($ʟ_args);
		unset($ʟ_args);

		echo '    <h2>Vytvořit vlákno</h2>
';
		$ʟ_tmp = $this->global->uiControl->getComponent('createThreadForm');
		if ($ʟ_tmp instanceof Nette\Application\UI\Renderable) $ʟ_tmp->redrawControl(null, false);
		$ʟ_tmp->render() /* line 4 */;
	}
}
