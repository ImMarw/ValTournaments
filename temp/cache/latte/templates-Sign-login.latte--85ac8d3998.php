<?php

declare(strict_types=1);

use Latte\Runtime as LR;

/** source: /home/marw/PhpstormProjects/ValTournamentss/app/Presentation/Sign/templates/Sign/login.latte */
final class Template_85ac8d3998 extends Latte\Runtime\Template
{
	public const Source = '/home/marw/PhpstormProjects/ValTournamentss/app/Presentation/Sign/templates/Sign/login.latte';

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

		echo '    ';
		$form = $this->global->formsStack[] = $this->global->uiControl['signInForm'] /* line 3 */;
		Nette\Bridges\FormsLatte\Runtime::initializeForm($form);
		echo Nette\Bridges\FormsLatte\Runtime::renderFormBegin($form, []) /* line 3 */;
		echo '
        <div class="mb-3">
            ';
		echo ($ʟ_label = Nette\Bridges\FormsLatte\Runtime::item('username', $this->global)->getLabel()) /* line 5 */;
		echo '
        ';
		echo Nette\Bridges\FormsLatte\Runtime::item('username', $this->global)->getControl()->addAttributes(['class' => 'form-control']) /* line 6 */;
		echo '
        </div>
        <div class="mb-3">
            ';
		echo ($ʟ_label = Nette\Bridges\FormsLatte\Runtime::item('password', $this->global)->getLabel()) /* line 9 */;
		echo '
        ';
		echo Nette\Bridges\FormsLatte\Runtime::item('password', $this->global)->getControl()->addAttributes(['class' => 'form-control']) /* line 10 */;
		echo '
        </div>
        <button class="btn btn-primary">';
		echo Nette\Bridges\FormsLatte\Runtime::item('send', $this->global)->getControl() /* line 12 */;
		echo '</button>
    ';
		echo Nette\Bridges\FormsLatte\Runtime::renderFormEnd(array_pop($this->global->formsStack)) /* line 13 */;

		echo '

';
	}
}
