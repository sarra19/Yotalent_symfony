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
public class Remboursement {
    private int idRem;
    String dateRem;
    private Ticket IdT;

    public Remboursement() {
    }

    public Remboursement(int idRem, String dateRem, Ticket IdT) {
        this.idRem = idRem;
        this.dateRem = dateRem;
        this.IdT = IdT;
    }

    public Remboursement(String dateRem, Ticket IdT) {
        this.dateRem = dateRem;
        this.IdT = IdT;
    }

    public int getIdRem() {
        return idRem;
    }

    public void setIdRem(int idRem) {
        this.idRem = idRem;
    }

    public String getDateRem() {
        return dateRem;
    }

    public void setDateRem(String dateRem) {
        this.dateRem = dateRem;
    }

    public Ticket getIdT() {
        return IdT;
    }

    public void setIdT(Ticket IdT) {
        this.IdT = IdT;
    }

    @Override
    public String toString() {
        return "Remboursement{" + "idRem=" + idRem + ", dateRem=" + dateRem + ", IdT=" + IdT + '}';
    }

    @Override
    public int hashCode() {
        int hash = 5;
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
        final Remboursement other = (Remboursement) obj;
        if (this.idRem != other.idRem) {
            return false;
        }
        if (!Objects.equals(this.dateRem, other.dateRem)) {
            return false;
        }
        if (!Objects.equals(this.IdT, other.IdT)) {
            return false;
        }
        return true;
    }

   
    
}
