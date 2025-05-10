<?php
namespace App\Presentation\Forum;

use Nette;
use App\Model\ForumManager;

final class ForumPresenter extends Nette\Application\UI\Presenter
{
    private ForumManager $forumManager;

    public function __construct(ForumManager $forumManager)
    {
        parent::__construct();
        $this->forumManager = $forumManager;
    }

    public function renderDefault(): void
    {
        $this->template->threads = $this->forumManager->getThreads();
    }

    public function renderThread(int $id): void
    {
        $thread = $this->forumManager->getThreadById($id);
        if (!$thread) {
            $this->error('Vlákno nenalezeno.');
        }

        $this->template->thread = $thread;
        $this->template->posts = $this->forumManager->getPostsWithUsernames($id); // změna zde
    }

    public function renderCreateThread(): void
    {
        if (!$this->getUser()->isLoggedIn()) {
            $this->redirect('Sign:login');
        }
    }

    protected function createComponentCreateThreadForm(): Nette\Application\UI\Form
    {
        $form = new Nette\Application\UI\Form;

        $form->addText('title', 'Název vlákna:')->setRequired();
        $form->addSubmit('send', 'Vytvořit vlákno');

        $form->onSuccess[] = function ($form, $values): void {
            $id = $this->forumManager->addThread($values->title, $this->getUser()->getId());
            $this->redirect('Forum:thread', $id);
        };

        return $form;
    }

    protected function createComponentPostForm(): Nette\Application\UI\Form
    {
        $form = new Nette\Application\UI\Form;

        $form->addTextArea('content', 'Text:')->setRequired();
        $form->addSubmit('send', 'Odeslat');

        $form->onSuccess[] = function ($form, $values): void {
            $threadId = $this->getParameter('id');
            $this->forumManager->addPost($threadId, $values->content, $this->getUser()->getId());
            $this->redirect('this');
        };

        return $form;
    }

}