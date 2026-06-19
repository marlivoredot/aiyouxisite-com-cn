<?php

namespace App\Helpers;

class LinkCard
{
    private string $baseUrl;
    private string $siteName;
    private string $defaultImage;
    private array $keywords;

    public function __construct()
    {
        $this->baseUrl = 'https://aiyouxisite.com.cn';
        $this->siteName = '爱游戏';
        $this->defaultImage = '/images/placeholder.png';
        $this->keywords = ['爱游戏', '游戏平台', '在线娱乐'];
    }

    public function setBaseUrl(string $url): void
    {
        $this->baseUrl = $url;
    }

    public function setSiteName(string $name): void
    {
        $this->siteName = $name;
    }

    public function setDefaultImage(string $path): void
    {
        $this->defaultImage = $path;
    }

    public function renderCard(array $data): string
    {
        $title = $this->escape($data['title'] ?? $this->siteName);
        $description = $this->escape($data['description'] ?? '欢迎来到爱游戏');
        $url = $this->escape($data['url'] ?? $this->baseUrl);
        $image = $this->escape($data['image'] ?? $this->defaultImage);
        $keywordList = $data['keywords'] ?? $this->keywords;

        $keywordsHtml = '';
        foreach ($keywordList as $keyword) {
            $kw = $this->escape($keyword);
            $keywordsHtml .= "<span class=\"link-card-tag\">{$kw}</span>";
        }

        return <<<HTML
<div class="link-card">
    <a href="{$url}" target="_blank" rel="noopener noreferrer" class="link-card-link">
        <div class="link-card-image">
            <img src="{$image}" alt="{$title}" loading="lazy" />
        </div>
        <div class="link-card-content">
            <h3 class="link-card-title">{$title}</h3>
            <p class="link-card-description">{$description}</p>
            <div class="link-card-tags">{$keywordsHtml}</div>
        </div>
    </a>
</div>
HTML;
    }

    public function renderSimpleCard(string $title, string $url = null): string
    {
        $safeTitle = $this->escape($title);
        $safeUrl = $this->escape($url ?? $this->baseUrl);

        return <<<HTML
<a href="{$safeUrl}" class="link-card-simple" target="_blank" rel="noopener noreferrer">
    <span class="link-card-simple-title">{$safeTitle}</span>
    <span class="link-card-simple-arrow">→</span>
</a>
HTML;
    }

    public function renderCardList(array $items): string
    {
        $html = '<div class="link-card-list">';
        foreach ($items as $item) {
            $html .= $this->renderCard($item);
        }
        $html .= '</div>';
        return $html;
    }

    private function escape(string $value): string
    {
        return htmlspecialchars($value, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }

    public static function getExampleData(): array
    {
        return [
            'title' => '爱游戏 - 精彩游戏平台',
            'description' => '提供海量精品游戏，畅享极致娱乐体验。爱游戏，让快乐触手可及。',
            'url' => 'https://aiyouxisite.com.cn',
            'image' => '/images/aiyouxi-banner.jpg',
            'keywords' => ['爱游戏', '游戏平台', '在线娱乐', '精品游戏']
        ];
    }

    public static function getExampleItems(): array
    {
        return [
            [
                'title' => '爱游戏热门推荐',
                'description' => '精选热门游戏，每日更新推荐。',
                'url' => 'https://aiyouxisite.com.cn/hot',
                'image' => '/images/hot.jpg',
                'keywords' => ['热门', '推荐']
            ],
            [
                'title' => '爱游戏最新上线',
                'description' => '新游首发，抢先体验。',
                'url' => 'https://aiyouxisite.com.cn/new',
                'image' => '/images/new.jpg',
                'keywords' => ['新游', '首发']
            ]
        ];
    }
}