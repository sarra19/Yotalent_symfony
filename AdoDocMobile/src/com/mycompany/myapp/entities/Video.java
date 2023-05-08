/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package com.mycompany.myapp.entities;

/**
 *
 * @author MSI GF63
 */
import java.util.Date;

/**
 *
 * @razi sniha
 */
public class Video {
    private int idVid;
    private String nomVid,url;
  

       private int idEST;

    public Video() {
    }

    public Video(String nomVid, String url) {
        this.nomVid = nomVid;
        this.url = url;
    }

    public Video(String nomVid, String url, int idEST) {
        this.nomVid = nomVid;
        this.url = url;
        this.idEST = idEST;
    }

    public Video(String nomVid) {
        this.nomVid = nomVid;
    }

    public Video(int idVid, String nomVid, String url, int idEST) {
        this.idVid = idVid;
        this.nomVid = nomVid;
        this.url = url;
        this.idEST = idEST;
    }

    public int getIdVid() {
        return idVid;
    }

    public void setIdVid(int idVid) {
        this.idVid = idVid;
    }

    public String getNomVid() {
        return nomVid;
    }

    public void setNomVid(String nomVid) {
        this.nomVid = nomVid;
    }

    public String getUrl() {
        return url;
    }

    public void setUrl(String url) {
        this.url = url;
    }

    public int getIdEST() {
        return idEST;
    }

    public void setIdEST(int idEST) {
        this.idEST = idEST;
    }

    @Override
    public String toString() {
        return "Video{" + "idVid=" + idVid + ", nomVid=" + nomVid + ", url=" + url + ", idEST=" + idEST + '}';
    }


    
    
}
