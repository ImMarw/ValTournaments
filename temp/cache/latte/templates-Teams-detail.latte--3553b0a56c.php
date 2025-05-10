<?php

declare(strict_types=1);

use Latte\Runtime as LR;

/** source: /home/marw/PhpstormProjects/ValTournamentss/app/Presentation/Teams/templates/Teams/detail.latte */
final class Template_3553b0a56c extends Latte\Runtime\Template
{
	public const Source = '/home/marw/PhpstormProjects/ValTournamentss/app/Presentation/Teams/templates/Teams/detail.latte';

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
			foreach (array_intersect_key(['member' => '9'], $this->params) as $ʟ_v => $ʟ_l) {
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

		echo '    <h2>';
		echo LR\Filters::escapeHtmlText($team->name) /* line 3 */;
		echo '</h2>

    <img src="/images/';
		echo LR\Filters::escapeHtmlAttr($team->logo) /* line 5 */;
		echo '" alt="';
		echo LR\Filters::escapeHtmlAttr($team->name) /* line 5 */;
		echo '" class="img-fluid mb-3">

    <h4>Členové týmu:</h4>
    <ul>
';
		foreach ($members as $member) /* line 9 */ {
			echo '            <li>';
			echo LR\Filters::escapeHtmlText($member->ref('users', 'user_id')->username) /* line 10 */;
			echo '</li>
';

		}

		echo '    </ul>
';
	}
}
