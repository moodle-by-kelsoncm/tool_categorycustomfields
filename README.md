# moodle-tool_categorycustomfields

[English](#english) · [Português (Brasil)](#português-brasil)

Documentation / Documentação: <https://moodle-fields-suite.github.io/tool_categorycustomfields/>

## English

Custom fields for course categories. Moodle has custom fields for courses, cohorts and groups, but not for categories: this admin tool adds them, with every field type installed on the site (text, text area, menu, checkbox, date, JSON...). Fields are managed at *Site administration > Courses > Category custom fields*; values are edited from the category settings menu, shown on the category page according to each field's visibility and read by integrations through the `tool_categorycustomfields_get_values` web service. Supports Moodle 4.5 LTS and 5.3 LTS.

Install: copy this repository to `admin/tool/categorycustomfields` (`public/admin/tool/categorycustomfields` on Moodle 5.1+) and visit *Site administration > Notifications*.

## Português (Brasil)

Campos personalizados para categorias de curso. O Moodle tem campos personalizados para cursos, coortes e grupos, mas não para categorias: esta ferramenta administrativa os acrescenta, com todos os tipos de campo instalados no site (texto, área de texto, menu, caixa de seleção, data, JSON...). Os campos são geridos em *Administração do site > Cursos > Campos personalizados de categoria*; os valores são editados pelo menu de configurações da categoria, aparecem na página da categoria conforme a visibilidade de cada campo e podem ser lidos por integrações pelo web service `tool_categorycustomfields_get_values`. Suporta Moodle 4.5 LTS e 5.3 LTS.

Instalação: copie este repositório para `admin/tool/categorycustomfields` (`public/admin/tool/categorycustomfields` no Moodle 5.1+) e acesse *Administração do site > Notificações*.

## Development / Desenvolvimento

- JavaScript sources are in `amd/src`; rebuild `amd/build` with `npx grunt amd --root=public/admin/tool/categorycustomfields` in a Moodle checkout.
- CI (`.github/workflows/ci.yml`) runs `moodle-plugin-ci` on Moodle 4.5 and 5.3 with PostgreSQL and MariaDB; run it locally with [`act`](https://github.com/nektos/act) before pushing.

## Support and privacy / Suporte e privacidade

- Issue tracker / Rastreador de issues: <https://github.com/moodle-fields-suite/tool_categorycustomfields/issues>
- Privacy / Privacidade: the values belong to course categories, not to users; nothing leaves Moodle / os valores pertencem às categorias, não aos usuários; nada sai do Moodle.
- Translations / Traduções: only English is shipped; other languages go through AMOS / o pacote traz só inglês; outros idiomas via AMOS.

## License / Licença

GNU GPL v3 or later. See [LICENSE](LICENSE).
