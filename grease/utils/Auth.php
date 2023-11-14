<?php

/**
 * Classe para Autenticação
 *
 * @package ChamaSamu
 * @author [MrNullus] <[gustavojs417@gmail.com]>
 * @version 1.0
 *
*/
class Auth {

  /**
   * Verifica se o usuário está autenticado e possui a permissão adequada.
   *
   * @param string $user O tipo de usuário permitido ('vis', 'all' ou outro tipo definido).
   *                     - 'vis': Permite acesso apenas a usuários autenticados.
   *                     - 'all': Permite acesso a todos os usuários, autenticados ou não.
   *                     - Outro tipo de usuário: Permite acesso somente a usuários autenticados com o mesmo tipo.
   * @return bool Retorna true se o usuário estiver autenticado e tiver a permissão adequada, caso contrário, redireciona para a página de login e retorna false.
   */
  public static function check($user = 'vis')
  {
    if (!isset($_SESSION['usuario'])) {
      self::redirectToLogin();
      return false;
    }

    if ($user === 'all') {
      return true;
    } elseif ($_SESSION['usuario']['tipo_usuario'] !== $user) {
      self::redirectToLogin();
      return false;
    }

    return true;
  }

  /**
   * Realiza o login do usuário.
   *
   * @param array $userData Os dados do usuário a serem armazenados na sessão após o login.
   * @return void
   */
  public static function login($userData)
  {
    $_SESSION['usuario'] = $userData;
  }

  /**
   * Faz o logout do usuário.
   *
   * @return void
   */
  public static function logout()
  {
    unset($_SESSION['usuario']);
    session_destroy();
    self::redirectToLogin();
  }

  /**
   * Verifica se o usuário está logado.
   *
   * @return bool Retorna true se o usuário estiver logado, caso contrário, retorna false.
   */
  public static function isLogged()
  {
    if (!isset($_SESSION['usuario']) || empty($_SESSION['usuario'])) {
      Auth::redirectToLogin();
    }

    return;
  }

  /**
   * Obtém os dados do usuário autenticado.
   *
   * @return array|bool Retorna os dados do usuário autenticado como um array associativo. Se o usuário não estiver logado, retorna false.
   */
  public static function getUserData()
  {
    return isset($_SESSION['usuario']) ? $_SESSION['usuario'] : false;
  }

  /**
   * Redireciona o usuário para uma página específica após o login ou logout.
   *
   * @param string $page A URL da página para redirecionar o usuário.
   * @return void
   */
  public static function redirectTo($page)
  {
    header('Location: ' . $page);
    exit;
  }

  /**
   * Redireciona o usuário para a página de login.
   *
   * @return void
   */
  public static function redirectToLogin()
  {
    self::redirectTo($_ENV['VIEWS'] . '/auth/login.php');
  }
}
