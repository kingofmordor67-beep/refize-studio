<!-- ========================== -->
<!-- ALL MODALS -->
<!-- ========================== -->

<!-- Admin Add/Edit News Modal (CMS Admin Interface) -->
<div class="modal-overlay" id="adminModal">
    <div class="modal-content admin-modal">
        <button class="modal-close" onclick="closeModal('adminModal')">&times;</button>
        <h2 id="adminModalTitle">New Changelog</h2>
        <form class="auth-form" id="newsForm" onsubmit="submitNews(event)">
            <input type="hidden" id="newsId" value="">
            <div class="admin-form-row">
                <input id="newsTitle" placeholder="Title (e.g. New Horizons)" required>
                <input id="newsVersion" placeholder="Version (e.g. v2.1)" required>
            </div>
            <input id="newsThumb" placeholder="Thumbnail Image URL">
            <textarea id="newsBody" placeholder="What's new in this update?" required rows="5"></textarea>
            <button type="submit" class="cta-btn" style="width: 100%; margin-top: 10px;">
                <span id="newsSubmitBtn">Post Update</span>
            </button>
        </form>
    </div>
</div>

<!-- News Detail Modal -->
<div class="modal-overlay" id="newsModal">
    <div class="modal-content mega-modal-content">
        <button class="modal-close" style="position: absolute; right: 20px; top: 20px; border: none; background: none; font-size: 1.5rem; cursor: pointer; z-index: 100; color: white;" onclick="closeModal('newsModal')">
            &times;
        </button>
        <!-- Dynamic media container: will hold either image or YouTube iframe -->
        <div class="mm-hero" id="newsModalMedia" style="height: 300px; background: black; position: relative; overflow: hidden;">
            <!-- Content injected by JavaScript -->
        </div>
        <div class="mm-body" style="padding: 30px;">
            <span class="badge" id="newsModalVersion"></span>
            <h2 id="newsModalTitle"></h2>
            <p id="newsModalBody" style="white-space: pre-wrap;"></p>
        </div>
    </div>
</div>

<!-- CMS Admin Access Modal -->
<div class="modal-overlay" id="cmsAdminModal">
    <div class="modal-content">
        <button class="modal-close" onclick="closeModal('cmsAdminModal')">&times;</button>
        <h2>🔐 CMS Admin Access</h2>
        <p style="margin-bottom: 20px; color: #636e72;">
            Enter your admin key to manage news content.
        </p>
        <div class="error-banner" id="cmsError" style="display: none;"></div>
        <form class="auth-form" id="cmsLoginForm" onsubmit="verifyCMSAdmin(event)">
            <div class="input-group" style="margin-bottom: 20px;">
                <input type="password" id="cmsAdminKey" placeholder="Admin Key" required
                    style="width: 100%; padding: 15px; border-radius: 10px; border: 1px solid #ddd;">
            </div>
            <button type="submit" class="cta-btn" style="width: 100%; margin-top: 10px;">
                Access CMS
            </button>
        </form>
    </div>
</div>

