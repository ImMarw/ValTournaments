<?php

declare(strict_types=1);

use Latte\Runtime as LR;

/** source: /home/marw/PhpstormProjects/ValTournamentss/app/Presentation/Sign/templates/Sign/register.latte */
final class Template_da8ed424e0 extends Latte\Runtime\Template
{
	public const Source = '/home/marw/PhpstormProjects/ValTournamentss/app/Presentation/Sign/templates/Sign/register.latte';

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

		echo '    <h2>Registrace</h2>

';
		$form = $this->global->formsStack[] = $this->global->uiControl['signUpForm'] /* line 5 */;
		Nette\Bridges\FormsLatte\Runtime::initializeForm($form);
		echo '    <form';
		echo Nette\Bridges\FormsLatte\Runtime::renderFormBegin(end($this->global->formsStack), ['class' => null], false) /* line 5 */;
		echo ' class="mt-3">
        <div class="mb-3">
            <label for="username" class="form-label">Uživatelské jméno</label>
            <input type="text" id="username"';
		echo ($ʟ_elem = Nette\Bridges\FormsLatte\Runtime::item('username', $this->global)->getControlPart())->addAttributes(['type' => null, 'id' => null, 'class' => null])->attributes() /* line 8 */;
		echo ' class="form-control">
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" id="email"';
		echo ($ʟ_elem = Nette\Bridges\FormsLatte\Runtime::item('email', $this->global)->getControlPart())->addAttributes(['type' => null, 'id' => null, 'class' => null])->attributes() /* line 13 */;
		echo ' class="form-control">
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Heslo</label>
            <input type="password" id="password"';
		echo ($ʟ_elem = Nette\Bridges\FormsLatte\Runtime::item('password', $this->global)->getControlPart())->addAttributes(['type' => null, 'id' => null, 'class' => null])->attributes() /* line 18 */;
		echo ' class="form-control">
        </div>

        <div class="mb-3">
            <label for="password_confirm" class="form-label">Heslo znovu</label>
            <input type="password" id="password_confirm"';
		echo ($ʟ_elem = Nette\Bridges\FormsLatte\Runtime::item('password_confirm', $this->global)->getControlPart())->addAttributes(['type' => null, 'id' => null, 'class' => null])->attributes() /* line 23 */;
		echo ' class="form-control">
        </div>

        <button type="submit" class="btn btn-success">Registrovat</button>
    ';
		echo Nette\Bridges\FormsLatte\Runtime::renderFormEnd(end($this->global->formsStack), false) /* line 5 */;
		echo '</form>
';
		array_pop($this->global->formsStack);
	}
}
