function globalScripts() {

  function openLinksInNewTab() {
    const posts_table = document.querySelector('.wp-list-table.posts, .wp-list-table.pages');
    if(posts_table) {
      const edit_links = posts_table.querySelectorAll('a.row-title, .row-actions .edit a');
      edit_links.forEach(link => {
        link.setAttribute('target', '_blank');
      });
    }
  }

  function Init() {
    openLinksInNewTab();
  }
  document.addEventListener('DOMContentLoaded', Init);
}
globalScripts();