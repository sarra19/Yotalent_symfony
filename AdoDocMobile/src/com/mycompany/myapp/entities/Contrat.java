/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package com.mycompany.myapp.entities;

/**
 *
 * @author ASMA
 */
public class Contrat {
    private int idC;
    private String nomC,DateDC,DateFC;
 private int idEST;
    public Contrat(String nomC) {
        this.nomC = nomC;
    }

    public Contrat() {
    }

    public Contrat(int idC, String nomC, String DateDC, String DateFC, int idEST) {
        this.idC = idC;
        this.nomC = nomC;
        this.DateDC = DateDC;
        this.DateFC = DateFC;
        this.idEST = idEST;
    }

    public Contrat(String nomC, String DateDC, String DateFC, int idEST) {
        this.nomC = nomC;
        this.DateDC = DateDC;
        this.DateFC = DateFC;
        this.idEST = idEST;
    }

    public String getDateDC() {
        return DateDC;
    }

    public int getIdC() {
        return idC;
    }

    public String getDateFC() {
        return DateFC;
    }

    public int getIdEST() {
        return idEST;
    }

    public String getNomC() {
        return nomC;
    }

    public void setDateDC(String DateDC) {
        this.DateDC = DateDC;
    }

    public void setDateFC(String DateFC) {
        this.DateFC = DateFC;
    }

    public void setIdC(int idC) {
        this.idC = idC;
    }

    public void setIdEST(int idEST) {
        this.idEST = idEST;
    }

    public void setNomC(String nomC) {
        this.nomC = nomC;
    }

    @Override
    public String toString() {
        return "Contrat{" + "idC=" + idC + ", nomC=" + nomC + ", DateDC=" + DateDC + ", DateFC=" + DateFC + ", idEST=" + idEST + '}';
    }

    
    
}
