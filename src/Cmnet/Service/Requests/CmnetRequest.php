<?php
namespace Cmnet\Service\Requests;

use \SoapClient;

/**
 * Padrão para as requisições do webservice
 *
 * @author Luís Otávio Cobucci Oblonczyk <lcobucci@gmail.com>
 */
interface CmnetRequest
{
    /**
     * Cria o XML da requisição baseado nos parâmetros enviados
     *
     * @param string $timestamp Data e hora da requisição
     * @param string $environment Ambiente destino
     * @param string $language Idioma
     * @return string
     */
    public function toXml($timestamp, $environment, $language);

    /**
     * Realiza a chamada SOAP
     *
     * @param \SoapClient $service Instância já configurada do webservice
     * @param string $timestamp Data e hora da requisição
     * @param string $environment Ambiente destino
     * @param string $language Idioma
     * @return mixed
     */
    public function call(SoapClient $service, $timestamp, $environment, $language);
}
