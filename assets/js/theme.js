function toggleTheme() {
    fetch('/project/theme.php?toggle_theme=1')
        .then(res => res.text())
        .then(theme => {
            document.body.className = theme;
        });
}
