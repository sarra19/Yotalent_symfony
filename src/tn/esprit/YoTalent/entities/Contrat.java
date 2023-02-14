/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package tn.esprit.YoTalent.entities;

import java.util.Objects;

/**
 *
 * @author USER
 */
public class Contrat {
    private int idC;
    private String nomC,DateDC,DateFC;
    private Voyage idVoy;

    public Contrat() {
    }

    public Contrat(String nomC, String DateDC, String DateFC) {
        this.nomC = nomC;
        this.DateDC = DateDC;
        this.DateFC = DateFC;
    }

    public Contrat(String nomC, String DateDC, String DateFC, Voyage idVoy) {
        this.nomC = nomC;
        this.DateDC = DateDC;
        this.DateFC = DateFC;
        this.idVoy = idVoy;
    }

    public Contrat(int idC, String nomC, String DateDC, String DateFC, Voyage idVoy) {
        this.idC = idC;
        this.nomC = nomC;
        this.DateDC = DateDC;
        this.DateFC = DateFC;
        this.idVoy = idVoy;
    }

    public int getIdC() {
        return idC;
    }

    public void setIdC(int idC) {
        this.idC = idC;
    }

    public String getNomC() {
        return nomC;
    }

    public void setNomC(String nomC) {
        this.nomC = nomC;
    }

    public String getDateDC() {
        return DateDC;
    }

    public void setDateDC(String DateDC) {
        this.DateDC = DateDC;
    }

    public String getDateFC() {
        return DateFC;
    }

    public void setDateFC(String DateFC) {
        this.DateFC = DateFC;
    }

    public Voyage getIdVoy() {
        return idVoy;
    }

    public void setIdVoy(Voyage idVoy) {
        this.idVoy = idVoy;
    }

    @Override
    public String toString() {
        return "Contrat{" + "idC=" + idC + ", nomC=" + nomC + ", DateDC=" + DateDC + ", DateFC=" + DateFC + ", idVoy=" + idVoy + '}';
    }

    @Override
    public int hashCode() {
        int hash = 3;
        return hash;
    }

    @Override
    public boolean equals(Object obj) {
        if (obj == null) {
            return false;
        }
        if (getClass() != obj.getClass()) {
            return false;
        }
        final Contrat other = (Contrat) obj;
        if (this.idC != other.idC) {
            return false;
        }
        if (!Objects.equals(this.nomC, other.nomC)) {
            return false;
        }
        if (!Objects.equals(this.DateDC, other.DateDC)) {
            return false;
        }
        if (!Objects.equals(this.DateFC, other.DateFC)) {
            return false;
        }
        if (!Objects.equals(this.idVoy, other.idVoy)) {
            return false;
        }
        return true;
    }
    
}