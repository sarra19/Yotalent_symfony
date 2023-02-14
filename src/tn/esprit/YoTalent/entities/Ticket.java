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
public class Ticket {
     private int  idT,prixT;
//     private Evenement idEv;
     private int idEv;
     
    public Ticket() {
    }

    public Ticket(int idT, int prixT, int idEv) {
        this.idT = idT;
        this.prixT = prixT;
        this.idEv = idEv;
    }

    public Ticket(int prixT, int idEv) {
        this.prixT = prixT;
        this.idEv = idEv;
    }

    public int getIdT() {
        return idT;
    }

    public void setIdT(int idT) {
        this.idT = idT;
    }

    public int getPrixT() {
        return prixT;
    }

    public void setPrixT(int prixT) {
        this.prixT = prixT;
    }

    public int getIdEv() {
        return idEv;
    }

    public void setIdEv(int idEv) {
        this.idEv = idEv;
    }

    @Override
    public String toString() {
        return "Ticket{" + "idT=" + idT + ", prixT=" + prixT + ", idEv=" + idEv + '}';
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
        final Ticket other = (Ticket) obj;
        if (this.idT != other.idT) {
            return false;
        }
        if (this.prixT != other.prixT) {
            return false;
        }
        if (!Objects.equals(this.idEv, other.idEv)) {
            return false;
        }
        return true;
    }

    

}
