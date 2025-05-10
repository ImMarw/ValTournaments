<?php

declare(strict_types=1);

use Latte\Runtime as LR;

/** source: /home/marw/PhpstormProjects/ValTournamentss/app/Presentation/Team/templates/Team/default.latte */
final class Template_baa06302d9 extends Latte\Runtime\Template
{
	public const Source = '/home/marw/PhpstormProjects/ValTournamentss/app/Presentation/Team/templates/Team/default.latte';

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

		echo '    <h2>Vytvoření týmu</h2>

';
		if ($user->isLoggedIn()) /* line 6 */ {
			$form = $this->global->formsStack[] = $this->global->uiControl['createTeamForm'] /* line 7 */;
			Nette\Bridges\FormsLatte\Runtime::initializeForm($form);
			echo '        <form';
			echo Nette\Bridges\FormsLatte\Runtime::renderFormBegin(end($this->global->formsStack), ['class' => null, 'enctype' => null], false) /* line 7 */;
			echo ' class="mt-3" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="name" class="form-label">Název týmu</label>
                <input type="text"';
			echo ($ʟ_elem = Nette\Bridges\FormsLatte\Runtime::item('name', $this->global)->getControlPart())->addAttributes(['type' => null, 'class' => null])->attributes() /* line 10 */;
			echo ' class="form-control">
            </div>

            <div class="mb-3">
                <label for="logo" class="form-label">Logo týmu (nahrát obrázek)</label>
                <input type="file"';
			echo ($ʟ_elem = Nette\Bridges\FormsLatte\Runtime::item('logo', $this->global)->getControlPart())->addAttributes(['type' => null, 'class' => null, 'accept' => null])->attributes() /* line 15 */;
			echo ' class="form-control" accept="image/*">
            </div>

            <button type="submit" class="btn btn-primary">Vytvořit tým</button>
        ';
			echo Nette\Bridges\FormsLatte\Runtime::renderFormEnd(end($this->global->formsStack), false) /* line 7 */;
			echo '</form>
';
			array_pop($this->global->formsStack);
		} else /* line 20 */ {
			echo '        <p>Pro vytvoření týmu se prosím přihlas.</p>
';
		}
	}
}
