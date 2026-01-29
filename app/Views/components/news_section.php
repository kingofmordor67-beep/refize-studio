<!-- News/Game Log Section -->
<section class="section-padding fade-in-section" id="news">
    <div class="section-header">
        <h2>Game Log</h2>
        <p>Track the evolution of the world</p>
    </div>
    <div class="container">
        <div class="dev-layout">
            <!-- Timeline Navigation -->
            <div class="timeline-nav">
                <div class="timeline-line"></div>
                <?php foreach ($news as $i => $item): ?>
                <div class="timeline-dot nav-btn-link" onclick="document.getElementById('post-<?= $i ?>').scrollIntoView({behavior: 'smooth', block: 'center'})">
                    <?= htmlspecialchars($item['version']) ?>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- News Cards Grid -->
            <div class="cards-grid dev-grid-wrapper" id="newsGrid">
                <?php foreach ($news as $i => $post): ?>
                <div id="post-<?= $i ?>" class="char-card dev-card tilt-card" data-id="<?= $post['id'] ?? $i ?>">
                    
                    <!-- CMS Admin Actions (shown only when admin is authenticated) -->
                    <div class="admin-actions cms-admin-only" style="display: none;">
                        <button class="btn-admin-small edit" onclick="openEditModal(<?= htmlspecialchars(json_encode($post)) ?>)">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn-admin-small delete" onclick="deleteNews('<?= $post['id'] ?? $i ?>')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>

                    <div class="dev-content-upper">
                        <div class="dev-badge"><?= htmlspecialchars($post['version']) ?></div>
                        <h3><?= htmlspecialchars($post['title']) ?></h3>
                        <p style="font-size: 0.9rem; color: #636e72; margin-bottom: 10px;">
                            <?= htmlspecialchars($post['date']) ?>
                        </p>
                        <div style="height: 120px; overflow: hidden; border-radius: 10px; margin-bottom: 15px;">
                            <img 
                                src="<?= htmlspecialchars($post['thumb'] ?: 'https://via.placeholder.com/400') ?>" 
                                style="width: 100%; height: 100%; object-fit: cover;" 
                                alt="<?= htmlspecialchars($post['title']) ?>"
                                onerror="this.src='https://via.placeholder.com/400?text=No+Image'"
                            >
                        </div>
                        <p><?= htmlspecialchars(substr($post['body'] ?? '', 0, 80)) ?>...</p>
                    </div>
                    <button class="card-link" style="background: none; border: none; cursor: pointer;" onclick="openNewsModal(<?= htmlspecialchars(json_encode($post)) ?>)">
                        Read Changelog &rarr;
                    </button>
                </div>
                <?php endforeach; ?>
                
                <?php if (empty($news)): ?>
                <div class="char-card dev-card" style="grid-column: span 2; text-align: center; padding: 60px;">
                    <i class="fas fa-newspaper" style="font-size: 3rem; color: var(--primary); margin-bottom: 20px;"></i>
                    <h3>No News Yet</h3>
                    <p style="color: var(--text-light);">Check back soon for updates!</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

