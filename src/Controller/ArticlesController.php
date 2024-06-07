<?php
declare(strict_types=1);

namespace App\Controller;

class ArticlesController extends AppController
{
    /**
     * Undocumented function
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Flash');
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function index()
    {
        $articles = $this->paginate($this->Articles);
        $this->set(compact('articles'));
    }

    /**
     * Undocumented function
     *
     * @param $slug
     * @return void
     */
    public function view($slug = null)
    {
        $article = $this->Articles->findBySlug($slug)->firstOrFail();
        $this->set(compact('article'));
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function add()
    {
        $article = $this->Articles->newEmptyEntity();
        if ($this->request->is('post')) {
            $article = $this->Articles->patchEntity($article, $this->getRequest()->getData());
            $article->user_id = 1;
            if ($this->Articles->save($article)) {
                $this->Flash->success(__('Your article has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('Unable to add your article.'));
            }
        }

        $tags = $this->Articles->Tags->find('list')->all();
        $this->set(compact('tags'));
        $this->set(compact('article'));
    }

    /**
     * Undocumented function
     *
     * @param [type] $slug
     * @return void
     */
    public function edit($slug)
    {
        $article = $this->Articles->findBySlug($slug)->firstOrFail();
        if ($this->getRequest()->is(['post', 'put'])) {
            $this->Articles->patchEntity($article, $this->getRequest()->getData());
            if ($this->Articles->save($article)) {
                $this->Flash->success(__('Your article has been updated.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to update  your article.'));
        }

        $tags = $this->Articles->Tags->find('list')->all();
        $this->set(compact('tags'));
        $this->set(compact('article'));
    }

    public function delete($slug)
    {
        $this->getRequest()->allowMethod(['post', 'get']);

        $article = $this->Articles->findBySlug($slug)->firstOrFail();
        if ($this->Articles->delete($article)) {
            $this->Flash->success(__('The {0} article has been delete.', $article->title));

            $this->redirect(['action' => 'index']);
        }
    }

    public function tags()
    {
        $tags = $this->getRequest('pass');
        $articles = $this->Articles->find('tagged', [
            'tags' => $tags,
        ])
        ->all();

        $this->set(compact('tags'));
        $this->set(compact('articles'));
    }
}
