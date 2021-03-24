#ifndef orderRequest_h
#define orderRequest_h

#include "Classes_headers/shipment.h"

/****************************************************************
 * Class definition : orderRequest
 * @author Jaden Kandel, Steven Strange, Nathan Woodzisz
 * **************************************************************/

class OrderRequest {

public:
    int getAquired();

private:
    int requestDoseCount;
    int aquiredDoseCount;

};

#endif
