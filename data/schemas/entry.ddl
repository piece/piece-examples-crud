-- $Id$

CREATE TABLE entry (
  id serial,
  title varchar(255) NOT NULL,
  content text NOT NULL,
  rdate timestamp with time zone NOT NULL DEFAULT current_timestamp,
  mdate timestamp with time zone NOT NULL DEFAULT current_timestamp,
  PRIMARY KEY(id)
);

/*
 * Local Variables:
 * mode: sql
 * coding: iso-8859-1
 * tab-width: 2
 * indent-tabs-mode: nil
 * End:
 */
