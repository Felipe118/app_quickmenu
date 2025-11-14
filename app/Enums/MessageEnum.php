<?php

namespace App\Enums;

enum MessageEnum :string
{
    case ACESSO_NEGADO = 'Acesso negado';
    case SEM_PERMISSAO = 'Você não tem permissao para executar essa ação';
    case MENU_NAO_ENCONTRADO = 'Menu não encontrado';
    case RESTAURANTE_NAO_ENCONTRADO = 'Restaurante não encontrado';
    case ERRO_AO_SALVAR = 'Erro ao salvar';
    case ERRO_AO_ATUALIZAR = 'Erro ao atualizar';
    case ERRO_AO_DELETAR = 'Erro ao deletar';
    case ERRO_AO_BUSCAR = 'Erro ao buscar';
    case ERRO_AO_BUSCAR_TODOS = 'Erro ao buscar todos';
    case ERRO_AO_BUSCAR_PAGINADO = 'Erro ao buscar paginado';

}