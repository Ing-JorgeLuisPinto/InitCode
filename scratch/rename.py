import os

def replace_in_file(filepath, replacements):
    try:
        with open(filepath, 'r', encoding='utf-8') as f:
            content = f.read()
    except Exception as e:
        print(f"Error reading {filepath}: {e}")
        return

    new_content = content
    for old, new in replacements:
        new_content = new_content.replace(old, new)
        
    if new_content != content:
        try:
            with open(filepath, 'w', encoding='utf-8') as f:
                f.write(new_content)
            print(f"Updated: {filepath}")
        except Exception as e:
            print(f"Error writing {filepath}: {e}")

def main():
    base_dir = r"c:\Users\pinto\OneDrive\Documentos\COSAS U\Semestre 5\Backend\proyecto"
    
    general_replacements = [
        ("CodePath Platform", "InitCode Platform"),
        ("codepath.site", "initcode.app"),
        ("CodePath", "InitCode"),
        ("CODEPATH", "INITCODE"),
        ("codepath", "initcode"),
    ]
    
    case_sensitive_only_replacements = [
        ("CodePath Platform", "InitCode Platform"),
        ("codepath.site", "initcode.app"),
        ("CodePath", "InitCode"),
    ]

    # Directories to process
    target_dirs = [
        os.path.join(base_dir, "resources", "views"),
        os.path.join(base_dir, "app"),
        os.path.join(base_dir, "config"),
        os.path.join(base_dir, "database", "seeders"),
    ]
    
    for d in target_dirs:
        for root, _, files in os.walk(d):
            for file in files:
                filepath = os.path.join(root, file)
                
                # Exclude python script itself and other unrelated
                if not file.endswith(('.php', '.blade.php')):
                    continue
                    
                # Use general replacements (which includes lowercase codepath->initcode) 
                # ONLY for views, README, config/app.php, controllers, and seeders as specified.
                
                # To be safe, let's apply general replacements to views, app, config/app.php, seeders.
                # But let's restore DB_DATABASE = codepath if it appears anywhere.
                # Actually, only resources/views/ and README.md explicitly need "codepath" -> "initcode".
                
                is_view = "resources\\views" in filepath or "resources/views" in filepath
                
                replacements_to_use = general_replacements if is_view else case_sensitive_only_replacements
                
                # config/app.php
                if file == "app.php" and "config" in root:
                    replace_in_file(filepath, [("APP_NAME', 'CodePath'", "APP_NAME', 'InitCode'")])
                    continue
                
                replace_in_file(filepath, replacements_to_use)

    # Specific files
    env_file = os.path.join(base_dir, ".env")
    if os.path.exists(env_file):
        replace_in_file(env_file, [
            ("APP_NAME=CodePath", "APP_NAME=InitCode"),
            ("MAIL_FROM_NAME=CodePath", "MAIL_FROM_NAME=InitCode")
        ])
        
    readme_file = os.path.join(base_dir, "README.md")
    if os.path.exists(readme_file):
        replace_in_file(readme_file, general_replacements)

if __name__ == "__main__":
    main()
