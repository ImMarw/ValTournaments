<?php declare(strict_types=1);

namespace App\Presentation\Forum;

use Nette\Application\UI\Form;
use Nette\Application\UI\Presenter;
use App\Model\ForumRepository;

final class ForumPresenter extends Presenter
{
    private ForumRepository $forum;

    public function __construct(ForumRepository $forum)
    {
        parent::__construct();
        $this->forum = $forum;
    }

    // ── Topics list: GET /forum ───────────────────────
    public function renderDefault(): void
    {
        $this->template->title  = 'Forum';
        $this->template->topics = $this->forum->getAllTopics();
    }

    // ── New topic form: GET|POST /forum/create ───────
    public function renderCreate(): void
    {
        $this->template->title       = 'New Topic';
        $this->user->isLoggedIn() || $this->error(403);
    }

    protected function createComponentTopicForm(): Form
    {
        $this->user->isLoggedIn() || $this->error(403);

        $form = new Form;
        $form->addText('title', 'Topic title:')
            ->setRequired();
        $form->addSubmit('send', 'Create Topic');
        $form->onSuccess[] = [$this, 'topicFormSucceeded'];
        return $form;
    }

    public function topicFormSucceeded(Form $form, \stdClass $v): void
    {
        $id = $this->forum->addTopic(
            (int) $this->getUser()->getId(),
            $v->title
        );
        $this->redirect('Forum:topic', $id);
    }

    // ── Show & post replies: GET|POST /forum/<id> ─────
    public function renderTopic(int $id): void
    {
        $topic = $this->forum->getTopic($id)
            ?? $this->error(404);

        $this->template->title = $topic->title;
        $this->template->topic = $topic;
        $this->template->posts = $this->forum->getPosts($id);
    }

    protected function createComponentReplyForm(): Form
    {

        $form = new Form;
        $form->addTextArea('content', 'Your reply:')
            ->setRequired();

        // ← here
        $form->addHidden('topicId')
            ->setDefaultValue((string) $this->getParameter('id'));

        $form->addSubmit('send', 'Post reply');
        $form->onSuccess[] = [$this, 'replyFormSucceeded'];
        return $form;
    }

    public function replyFormSucceeded(Form $form, \stdClass $v): void
    {
        $this->forum->addPost(
            (int) $v->topicId,
            (int) $this->getUser()->getId(),
            $v->content
        );
        $this->redirect('this');
    }
}