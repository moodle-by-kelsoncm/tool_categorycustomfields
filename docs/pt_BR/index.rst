moodle-tool_categorycustomfields
================================

**Campos personalizados para categorias de curso: gerencie como os campos personalizados do curso, edite os valores em cada categoria e mostre-os na página da categoria.**

.. figure:: img/display.png
   :alt: Página de uma categoria com os valores dos campos personalizados acima da lista de cursos.
   :width: 100%

   Os valores visíveis aparecem na página da categoria, junto à descrição.

* **Campos onde o Moodle não tem.** O Moodle tem campos personalizados para cursos, coortes e grupos, mas não para categorias. Esta ferramenta acrescenta a área que falta.
* **Todos os tipos de campo.** Texto, área de texto, menu, caixa de seleção, data e qualquer outro tipo instalado no site, com as configurações de sempre (obrigatório, único, valor padrão).
* **Controle de quem vê cada valor.** Cada campo é visível para todos, só para quem pode editar os valores ou para ninguém.
* **Pronto para integrações.** Um web service devolve os valores que o usuário pode ver.

English version: `English <../en/index.html>`_.

.. toctree::
   :maxdepth: 2
   :caption: Conteúdo

   installation
   configuration
   usage

Principais recursos
-------------------

* Gestão dos campos em *Administração do site > Cursos > Campos personalizados de categoria*, com a mesma interface dos campos personalizados do curso.
* Configurações da área por campo: *Bloqueado* e *Visível para*.
* Edição dos valores pelo menu de configurações da categoria, com permissões no contexto da categoria.
* Valores visíveis na página da categoria.
* Web service ``tool_categorycustomfields_get_values``, também disponível para AJAX e para o aplicativo Moodle.
* Valores excluídos junto com a categoria.
* **Moodle 4.5 LTS e 5.3 LTS**: testado numa matriz de CI com PostgreSQL e MariaDB.

Links
-----

* Código-fonte e issues: https://github.com/moodle-fields-suite/tool_categorycustomfields
